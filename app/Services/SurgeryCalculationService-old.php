<?php

namespace App\Services;

use App\Models\Hard\Eye\EyeVariable;
use App\Models\Patient;
use Illuminate\Http\Request;

class SurgeryCalculationService_old
{
    public $globalData = [];
    public $test;
    private string $surgeryCalculationKey;
    public function __construct($id, $eye, $productSlug)
    {
        $this->surgeryCalculationKey = $productSlug;
        try {
            $patient = Patient::findOrFail($id);

//            $this->globalData['age'] = $userInfo->date_of_birth ? Carbon::parse($userInfo->date_of_birth)->diff(Carbon::now())->format('%y') : 0;
//            $this->globalData['age'] = $this->globalData['age'] > 0 ? $this->globalData['age'] : 1;

            $this->globalData = EyeVariable::where('patient_id',$id)->where('eye_type',$eye)->first()->toArray();
            $this->globalData['age'] = $patient->age;
            $this->globalData['type'] = $eye;

                // Conditions for ['prk', 'trans-prk', 'lasik', 'femtolasik', 'smile']
                if (in_array($productSlug, ['prk', 'trans_prk', 'lasik', 'femtolasik', 'smile'])) {
                    if (isset($this->globalData['subjective_ref_sph']) && !empty($this->globalData['subjective_ref_sph'])) {
                        if ($this->globalData['subjective_ref_sph'] < 0) {
                            $this->globalData['file_calculate_sph_surgery'] = $this->calculateSphSurgery($this->globalData['age'], $this->globalData['subjective_ref_sph'], $productSlug);
                            if (!empty($this->globalData['file_calculate_sph_surgery'])) {
                                $this->globalData['diopter_D_sph'] = $this->globalData['subjective_ref_sph'] + $this->globalData['file_calculate_sph_surgery'];
                            }
                        } elseif (!empty($this->globalData['optometry_cycloplegic_sph']) && $this->globalData['subjective_ref_sph'] > 0.5) {
                            $this->globalData['diopter_D_sph'] = $this->globalData['subjective_ref_sph'] + bcdiv(abs($this->globalData['subjective_ref_sph'] - $this->globalData['optometry_cycloplegic_sph']), 3, 2);
                        } else {
                            $this->globalData['diopter_D_sph'] = $this->globalData['subjective_ref_sph'];
                        }
                    }
                }

//                dd($this->globalData['subjective_ref_axis']);


                if (isset($this->globalData['subjective_ref_axis']) and !empty($this->globalData['subjective_ref_axis'])) {
                    $this->globalData['diopter_D_axis'] = $this->globalData['subjective_ref_axis'];
                }


//            if (abs($this->globalData['subjective_ref_cyl']) > abs($this->globalData['astig_topo'])) {
//               $cyl_p = ((abs($this->globalData['subjective_ref_cyl']) - abs($this->globalData['astig_topo'])) / 2);
//
//               if ($cyl_p == 0.25) {
//                  $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'] + 0.25;
//               } elseif ($cyl_p >= 0.5) {
//                  $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'] + 0.5;
//               } else {
//                  $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'];
//               }
//            } else {
//               $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'];
//            }
                if (isset($this->globalData['subjective_ref_cyl'])) {
                    if (isset($this->globalData['astig_topo'])) {
                        $cyl_p = abs($this->globalData['subjective_ref_cyl']) - abs($this->globalData['astig_topo']);
                        if ($cyl_p > 0 and $cyl_p <= 1) {
                            $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'] + 0.25;
                        } elseif ($cyl_p > 1 and $cyl_p <= 2) {
                            $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'] + 0.5;
                        } elseif ($cyl_p > 2) {
                            $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'] + 0.75;
                        } else {
                            $this->globalData['diopter_D_cyl'] = $this->globalData['subjective_ref_cyl'];
                        }
                    }
                }

                $this->globalData['optical_zone_mm'] = 6.5;

                if (isset($this->globalData['diopter_D_sph']) && isset($this->globalData['diopter_D_cyl'])) {
                    if ($this->globalData['diopter_D_sph'] < 0) {
                        $this->globalData['max_ablation_um'] = 15 * (abs($this->globalData['diopter_D_sph']) + abs($this->globalData['diopter_D_cyl']));
                    } elseif ($this->globalData['diopter_D_sph'] > 0) {
                        $this->globalData['max_ablation_um'] = 15 * (max(abs($this->globalData['diopter_D_sph']), abs($this->globalData['diopter_D_cyl'])));
                    }

                    $this->globalData['mmc_second'] = 8 * (abs($this->globalData['diopter_D_sph']) + abs($this->globalData['diopter_D_cyl']));
                }


            if (!empty($this->globalData['pachy_min']) && !empty($this->globalData['max_ablation_um'])) {
                $this->globalData['pta'] = ($this->globalData['max_ablation_um'] + 110) / intval($this->globalData['pachy_min']);
            }

            if (isset($this->globalData['KM_D'])) {
                if ($this->globalData['KM_D'] <= 41) {
                    $this->globalData['flap_diameter'] = 10;
                } elseif ($this->globalData['KM_D'] < 41 || $this->globalData['KM_D'] <= 45) {
                    $this->globalData['flap_diameter'] = 9.5;
                } elseif ($this->globalData['KM_D'] > 45) {
                    $this->globalData['flap_diameter'] = 9;
                }
            }

            if (isset($this->globalData['subjective_ref_bcva'])) {
                if (strpos($this->globalData['subjective_ref_bcva'], '/') !== false) {
                    $positionExploded = explode('/', $this->globalData['subjective_ref_bcva']);

                    if (reset($positionExploded) >= 5 && isset($this->globalData['subjective_ref_axis'])) {
                        $this->globalData['position'] = $this->globalData['subjective_ref_axis'];
                    } elseif (reset($positionExploded) < 5 && isset($this->globalData['Axis_flat'])) {
                        $this->globalData['position'] = $this->globalData['Axis_flat'];
                    }
                }
            }

            if (!empty($this->globalData['pachy_min'])) {
                $this->globalData['depth_in_cornea'] = $this->globalData['pachy_min'] * 0.75;
            }

//            if (is_array($userInfo->eye_exam)) {
//                $this->globalData['eyeexam_examination_WTW'] = $userInfo->eye_exam['examination'][8]['items'][$eye == 2 ? 0 : 1]['value'];
//            }
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ]);
        }
    }
    public function calculateSphSurgery($age, $sph, $type)
    {
        if ($type == 'smile') {
            $table = [
                ['age\sph', 0, -0.25, -0.5, -1, -1.5, -2, -2.5, -3, -3.5, -4, -4.5, -5, -5.5, -6, -6.5, -7, -7.5, -8, -8.5, -9, -9.5, -10, -10.5, -11, -11.5, -12],
                [20, 0, -0.5, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.5, -0.5, 0, 0.5, 1, 1.5, 2],
                [25, 0, -0.5, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.5, -0.5, 0, 0.5, 1, 1.5, 2],
                [30, 0, -0.5, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.5, -0.5, 0, 0.5, 1, 1.5, 2],
                [35, 0, -0.5, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, 0, 0.5, 1, 1.5, 2],
                [40, 0, -0.5, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, 0, 0.5, 1, 1.5, 2],
                [45, 0, 0, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, 0.25, 0.25, 0.25, 0.25, 0, 0.5, 1, 1.5, 2],
                [50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0, 0.5, 1, 1.5, 2],
                [55, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0, 0.5, 1, 1.5, 2],
                [60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0, 0.5, 1, 1.5, 2],
                [65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0, 0.5, 1, 1.5, 2],
                [70, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0, 0.5, 1, 1.5, 2]
            ];
        } elseif ($type == 'prk' || $type == 'trans_prk') {
            $table = [
                ['age\sph', 0, -0.25, -0.5, -1, -1.5, -2, -2.5, -3, -3.5, -4, -4.5, -5, -5.5, -6, -6.5, -7, -7.5, -8, -8.5, -9, -9.5, -10, -10.5, -11, -11.5, -12],
                [20, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [25, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [30, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [35, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [40, 0, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0.25, 0.25, 0.5, 0.5, 0.75, 0.75, 1, 1.25, 1.5],
                [45, 0, 0, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [55, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [70, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5]
            ];
        } elseif ($type == 'lasik' || $type == 'femtolasik') {
            $table = [
                ['age\sph', 0, -0.25, -0.5, -1, -1.5, -2, -2.5, -3, -3.5, -4, -4.5, -5, -5.5, -6, -6.5, -7, -7.5, -8, -8.5, -9, -9.5, -10, -10.5, -11, -11.5, -12],
                [20, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [25, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [30, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [35, 0, -0.5, -0.75, -0.75, -0.75, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, 0, 0, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [40, 0, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.5, -0.25, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0.25, 0.25, 0.5, 0.5, 0.5, 0.75, 1, 1.25, 1.5],
                [45, 0, 0, -0.25, -0.25, -0.25, -0.25, -0.25, -0.25, -0.25, -0.25, -0.25, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [55, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5],
                [70, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.25, 0.25, 0.25, 0.25, 0.5, 0.75, 1, 1.25, 1.5]
            ];
        }

        $sphNew = null;
        $sphKey = null;
        $ageNew = null;
        $result = null;

        $sph = max($sph, -12);

        $age = max($age,20);

        $age = min($age,70);

        if (!empty($age) && !empty($sph)) {

               $ageNew = intval($age/5) * 5;


            foreach ($table[0] as $key => $row) {
                if ($sph >= $row && is_numeric($row)) {
                    $sphNew = $row;
                    $sphKey = $key;
                    break;
                }
            }

            foreach ($table as $row) {
                if ($ageNew == $row[0] && is_numeric($row[0])) {
                    $result = $row[$sphKey];
                }
            }
            $this->test = $result;
            return $result;
        } else {
            return 0;
        }
    }

    public function getKeraringICRS($cyl, $sph, $type)
    {
        if (in_array($type, [1, 2])) {
            $table = [
                ['-8', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/250|160/300', '90/250|160/300', '90/250|160/350', '90/250|160/350', '90/250|160/350'],
                ['-7', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/300', '90/200|160/350', '90/200|160/350', '90/200|160/350'],
                ['-6', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/200|160/300', '90/150|160/350', '90/150|160/350'],
                ['-5', '|160/300', '|160/300', '|160/300', '|160/300', '|160/300', '|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '90/150|160/300', '120/200|160/350', '120/200|160/350'],
                ['-4', '|160/250', '|160/250', '|160/250', '|160/250', '|160/250', '|160/250', '|160/300', '120/150|160/300', '120/150|160/300', '120/150|160/300', '120/250|160/350', '120/250|160/350'],
                ['-3', '|160/200', '|160/200', '|160/200', '|160/200', '|160/200', '|160/200', '|210/200', '|210/250', '|210/250', '|210/300', '|210/300', '|210/300'],
                ['-2', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|210/200', '|210/200', '160/150|160/250', '160/200|160/300', '160/200|160/300', '160/250|150/350'],
                ['-1', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|210/200', '160/150|160/250', '160/200|160/250', '160/250|160/300', '160/250|160/300', '160/250|160/350'],
                ['', '3', '2', '1', '0', '-1', '-2', '-3', '-4', '-5', '-6', '-7', '-8']
            ];
        } elseif ($type == 3) {
            $table = [
                ['-8', '90/200|120/300', '90/200|120/300', '90/200|120/300', '120/200|120/300', '120/200|120/300', '120/200|120/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/250|160/350', '90/250|160/350'],
                ['-7', '90/200|120/300', '90/200|120/300', '90/200|120/300', '120/200|120/300', '120/200|120/300', '120/200|120/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/250|160/350', '90/200|160/350'],
                ['-6', '90/200|120/300', '90/200|120/300', '90/200|120/300', '120/200|120/300', '120/200|120/300', '120/200|120/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/200|160/300', '160/250|160/350', '90/150|160/350'],
                ['-5', '90/200|90/250', '90/200|90/250', '90/200|90/250', '120/200|120/250', '120/200|120/250', '120/200|120/250', '160/150|160/250', '160/200|160/300', '160 /200|160/300', '160 /200|160/300', '160/250|160/350', '120/200|160/350'],
                ['-4', '90/150|90/200', '90/150|90/200', '90/150|90/200', '120/150|120/200', '120/150|120/200', '120/200|120/250', '160/150|160/250', '160/150|160/250', '160/150|160/250', '160/200|160/300', '160/250|160/350', '120/250|160/350'],
                ['-3', '90/150|90/200', '90/150|90/200', '90/150|90/200', '120/150|120/200', '120/150|120/200', '120/150|120/200', '160/150|160/250', '160/150|160/250', '160/150|160/250', '160/200|160/300', '160/250|160/350', '|210/300'],
                ['-2', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|160/200', '160/150|160/200', '160/150|160/200', '160/200|160/200', '160/250|160/300', '160/250|160/300', '160/250|150/350'],
                ['-1', '|160/150', '|160/150', '|160/150', '|160/150', '|160/150', '|160/200', '160/150|160/200', '160/150|160/200', '160/200|160/250', '160/250|160/300', '160/250|160/300', '160/250|160/350'],
                ['', '3', '2', '1', '0', '-1', '-2', '-3', '-4', '-5', '-6', '-7', '-8']
            ];
        } elseif ($type == 4) {
            $table = [
                ['-8', '120/250|120/250', '120/250|120/250', '120/250|120/250', '120/250|120/250', '120/300|120/300', '160/250|160/250', '160/300|160/300', '160/300|160/300', '160/300|160/300', '160/350|160/350', '160/350|160/350', '160/350|160/350'],
                ['-7', '120/250|120/250', '120/250|120/250', '120/250|120/250', '120/250|120/250', '120/300|120/300', '160/250|160/250', '160/300|160/300', '160/300|160/300', '160/300|160/300', '160/350|160/350', '160/350|160/350', '160/350|160/350'],
                ['-6', '90/300|90/300', '90/300|90/300', '90 /300|90/300', '120/250|120/250', '120/250|120/250', '160/250|160/250', '160/300|160/300', '160/300|160/300', '160/300|160/300', '160/300|160/300', '160/350|160/350', '160/350|160/350'],
                ['-5', '90/300|90/300', '90/300|90/300', '90/300|90/300', '120/250|120/250', '120/250|120/250', '160/250|160/250', '160/250|160/250', '160/300|160/300', '160/300|160/300', '160/300|160/300', '160/350|160/350', '160/350|160/350'],
                ['-4', '90/250|90/250', '90/250|90/250', '90/250|90/250', '120/200|120/200', '120/200|120/200', '160/200|160/200', '160/250|160/250', '160/250|160/250', '160/300|160/300', '160/300|160/300', '160/350|160/350', '160/350|160/350'],
                ['-3', '90/200|90/200', '90/200|90/200', '90/200|90/200', '120/200|120/200', '120/200|120/200', '160/200|160/200', '160/200|160/200', '160/250|160/250', '160/250|160/250', '160/300|160/300', '160/350|160/350', '160/350|160/350'],
                ['-2', '90/150|90/150', '90/150|90/150', '90/150|90/150', '120/150|120/150', '120/150|120/150', '160/150|160/150', '160/200|160/200', '160/200|160/200', '160/250|160/250', '160/250|160/250', '160/300|160/300', '160/300|160/300'],
                ['-1', '90/150|90/150', '90/150|90/150', '90/150|90/150', '120/150|120/150', '120/150|120/150', '160/150|160/150', '160/150|160/150', '160/200|160/200', '160/250|160/250', '160/250|160/250', '160/300|160/300', '160/300|160/300'],
                ['', '3', '2', '1', '0', '-1', '-2', '-3', '-4', '-5', '-6', '-7', '-8']
            ];
        }

        if ($type > 0 && !empty($cyl) && !empty($sph)) {
            $cylNew = null;
            $sphKey = null;

            foreach ($table as $key => $row) {
                if ($cyl <= $row[0] && $key != 8) {
                    $cylNew = $row[0];
                    break;
                }
            }

            foreach ($table[8] as $key => $row) {
                if ($sph > 0 && ($sph >= $row && $key != 0)) {
                    $sphKey = $key;
                    break;
                } elseif ($sph <= $row && $key != 0) {
                    $sphKey = $key;
                }
            }

            foreach ($table as $key => $row) {
                if (in_array($cylNew, $row) && $key != 8) {
                    $result = $row[$sphKey];
                }
            }
            return explode('|', $result);
        } else {
            return 0;
        }
    }

    public function getSurgeryData()
    {
//        return  response()->json($this->test);
        switch ($this->surgeryCalculationKey)
        {
            case 'prk' : return $this->surgery_prk();
            case 'trans_prk' : return $this->surgery_transprk();
            case 'lasik' : return  $this->surgery_lasik();
            case 'femtolasik' : return $this->surgery_femtolasik();
            case 'smile' : return $this->surgery_smile();
            case 'cxl' : return $this->surgery_kcn_cxl();
            case 'kcn_ring_keraring' : return  $this->surgery_kcn_ring_keraring();
            case 'kcn_ring_feraring' : return $this->surgery_kcn_ring_feraring();
            case 'kcn_ring_intacs' : return $this->surgery_kcn_ring_intacs();
            case 'kcn_ring_intacs_sk' :return $this->surgery_kcn_ring_intacs_sk();
            case 'kcn_ring_myoring' : return $this->surgery_kcn_ring_myoring();
        }
    }

    public function surgery_prk()
    {
        $conditions['Diopter'] = [
            ['title' => 'sph', 'value' => isset($this->globalData['diopter_D_sph']) ? $this->globalData['diopter_D_sph'] : null],
            ['title' => 'cyl', 'value' => isset($this->globalData['diopter_D_cyl']) ? $this->globalData['diopter_D_cyl'] : null],
            ['title' => 'axis', 'value' => isset($this->globalData['diopter_D_axis']) ? $this->globalData['diopter_D_axis'] : null]
        ];

        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'x', 'value' => isset($this->globalData['PupilX']) ? $this->globalData['PupilX'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'y', 'value' => isset($this->globalData['PupilY']) ? $this->globalData['PupilY'] : null];
        $conditions[] = ['group' => 'Optical Zone', 'title' => 'mm', 'value' => isset($this->globalData['optical_zone_mm']) ? $this->globalData['optical_zone_mm'] : null];
        $conditions[] = ['group' => 'Epithelium Thickness', 'title' => 'um', 'value' => 55];
        $conditions[] = ['group' => 'Max Ablation', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) ? $this->globalData['max_ablation_um'] : null, 'error' => isset($this->globalData['max_ablation_um']) && $this->globalData['max_ablation_um'] > 125 ? 1 : 0];
        $conditions[] = ['group' => 'RSB', 'title' => 'um', 'value' => (isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min'])) ? $this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] : null, 'error' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) && ($this->globalData['pachy_min'] - $this->globalData['max_ablation_um']) < 400 ? 1 : 0];
        $conditions[] = ['group' => 'MMC', 'title' => 'sec', 'value' => isset($this->globalData['mmc_second']) ? $this->globalData['mmc_second'] : null];

        return $conditions;
    }

    public function surgery_transprk()
    {
        $conditions[] = ['group' => 'Diopter', 'title' => 'sph', 'value' => isset($this->globalData['diopter_D_sph']) ? $this->globalData['diopter_D_sph'] : null, 'error' => !empty($this->globalData['diopter_D_sph']) && $this->globalData['diopter_D_sph'] >= 0 ? 1 : 0];
        $conditions[] = ['group' => 'Diopter', 'title' => 'cyl', 'value' => isset($this->globalData['diopter_D_cyl']) ? $this->globalData['diopter_D_cyl'] : null];
        $conditions[] = ['group' => 'Diopter', 'title' => 'axis', 'value' => isset($this->globalData['diopter_D_axis']) ? $this->globalData['diopter_D_axis'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'x', 'value' => isset($this->globalData['PupilX']) ? $this->globalData['PupilX'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'y', 'value' => isset($this->globalData['PupilY']) ? $this->globalData['PupilY'] : null];
        $conditions[] = ['group' => 'Optical Zone', 'title' => 'mm', 'value' => isset($this->globalData['optical_zone_mm']) ? $this->globalData['optical_zone_mm'] : null];
        $conditions[] = ['group' => 'Epithelium Thickness', 'title' => 'um', 'value' => 55];
        $conditions[] = ['group' => 'Max Ablation', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) ? $this->globalData['max_ablation_um'] + 55 : null, 'error' => isset($this->globalData['max_ablation_um']) && $this->globalData['max_ablation_um'] > 180 ? 1 : 0];
        $conditions[] = ['group' => 'RSB', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) ? $this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 55 : null, 'error' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) && ($this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 55) < 345 ? 1 : 0];
        $conditions[] = ['group' => 'MMC', 'title' => 'sec', 'value' => isset($this->globalData['mmc_second']) ? $this->globalData['mmc_second'] : null];

        return $conditions;
    }

    public function surgery_lasik()
    {
        $conditions[] = [
            'group' => 'Diopter',
            'title' => 'sph',
            'value' => isset($this->globalData['diopter_D_sph']) ? $this->globalData['diopter_D_sph'] : null
        ];
        $conditions[] = [
            'group' => 'Diopter',
            'title' => 'cyl',
            'value' => isset($this->globalData['diopter_D_cyl']) ? $this->globalData['diopter_D_cyl'] : null
        ];
        $conditions[] = [
            'group' => 'Diopter',
            'title' => 'axis',
            'value' => isset($this->globalData['diopter_D_axis']) ? $this->globalData['diopter_D_axis'] : null
        ];

        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'x', 'value' => isset($this->globalData['PupilX']) ? $this->globalData['PupilX'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'y', 'value' => isset($this->globalData['PupilY']) ? $this->globalData['PupilY'] : null];
        $conditions[] = ['group' => 'Optical Zone', 'title' => 'mm', 'value' => isset($this->globalData['optical_zone_mm']) ? $this->globalData['optical_zone_mm'] : null];
        $conditions[] = ['group' => 'Max Ablation', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) ? $this->globalData['max_ablation_um'] : null, 'error' => isset($this->globalData['max_ablation_um']) && $this->globalData['max_ablation_um'] > 140 ? 1 : 0];
        $conditions[] = ['group' => 'RSB', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) ? $this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 110 : null, 'error' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) && ($this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 110) < 300 ? 1 : 0];
        $conditions[] = ['group' => 'Flap Diameter', 'title' => 'Flap Diameter', 'value' => isset($this->globalData['flap_diameter']) ? $this->globalData['flap_diameter'] : null];
        $conditions[] = ['group' => 'Flap Thickness', 'title' => 'um', 'value' => 110];
        $conditions[] = ['group' => 'Hinge Length', 'title' => 'Hinge Length', 'value' => 0.5];
        $conditions[] = ['group' => 'Hinge Position', 'title' => 'Hinge Position', 'value' => 'superior'];
        $conditions[] = ['group' => 'Side Cut Angle', 'title' => 'Side Cut Angle', 'value' => 90];

        return $conditions;
    }

    public function surgery_femtolasik()
    {
        $conditions[] = ['group' => 'Diopter', 'title' => 'sph', 'value' => isset($this->globalData['diopter_D_sph']) ? $this->globalData['diopter_D_sph'] : null];
        $conditions[] = ['group' => 'Diopter', 'title' => 'cyl', 'value' => isset($this->globalData['diopter_D_cyl']) ? $this->globalData['diopter_D_cyl'] : null];
        $conditions[] = ['group' => 'Diopter', 'title' => 'axis', 'value' => isset($this->globalData['diopter_D_axis']) ? $this->globalData['diopter_D_axis'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'x', 'value' => isset($this->globalData['PupilX']) ? $this->globalData['PupilX'] : null];
        $conditions[] = ['group' => 'Pupil Offset', 'title' => 'y', 'value' => isset($this->globalData['PupilY']) ? $this->globalData['PupilY'] : null];
        $conditions[] = ['group' => 'Optical Zone', 'title' => 'mm', 'value' => isset($this->globalData['optical_zone_mm']) ? $this->globalData['optical_zone_mm'] : null];
        $conditions[] = ['group' => 'Max Ablation', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) ? $this->globalData['max_ablation_um'] : null, 'error' => isset($this->globalData['max_ablation_um']) && $this->globalData['max_ablation_um'] > 140 ? 1 : 0];
        $conditions[] = ['group' => 'RSB', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) ? $this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 110 : null, 'error' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) && ($this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 110) < 300 ? 1 : 0];
        $conditions[] = ['group' => 'Flap Diameter', 'title' => 'Flap Diameter', 'value' => isset($this->globalData['flap_diameter']) ? $this->globalData['flap_diameter'] : null];
        $conditions[] = ['group' => 'Flap Thickness', 'title' => 'um', 'value' => 110];
        $conditions[] = ['group' => 'Hinge Length', 'title' => 'Hinge Length', 'value' => 0.5];
        $conditions[] = ['group' => 'Hinge Position', 'title' => 'Hinge Position', 'value' => 'superior'];
        $conditions[] = ['group' => 'Side Cut Angle', 'title' => 'Side Cut Angle', 'value' => 90];


        return $conditions;
    }

    public function surgery_smile()
    {
        $conditions[] = ['group' => 'Diopter', 'title' => 'sph', 'value' => isset($this->globalData['diopter_D_sph']) ? $this->globalData['diopter_D_sph'] : null, 'error' => isset($this->globalData['diopter_D_sph']) && $this->globalData['diopter_D_sph'] >= 0 ? 1 : 0];
        $conditions[] = ['group' => 'Diopter', 'title' => 'cyl', 'value' => isset($this->globalData['diopter_D_cyl']) ? $this->globalData['diopter_D_cyl'] : null];
        $conditions[] = ['group' => 'Diopter', 'title' => 'axis', 'value' => isset($this->globalData['diopter_D_axis']) ? $this->globalData['diopter_D_axis'] : null];
        $conditions[] = ['group' => 'Optical Zone', 'title' => 'mm', 'value' => isset($this->globalData['optical_zone_mm']) ? $this->globalData['optical_zone_mm'] : null];
        $conditions[] = ['group' => 'Max Ablation', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) ? $this->globalData['max_ablation_um'] : null, 'error' => isset($this->globalData['max_ablation_um']) && $this->globalData['max_ablation_um'] > 160 ? 1 : 0];
        $conditions[] = ['group' => 'RSB', 'title' => 'um', 'value' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) ? $this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 135 : null, 'error' => isset($this->globalData['max_ablation_um']) && isset($this->globalData['pachy_min']) && ($this->globalData['pachy_min'] - $this->globalData['max_ablation_um'] - 135) < 270 ? 1 : 0];
        $conditions[] = ['group' => 'Treatment Pack Size', 'title' => 'Treatment Pack Size', 'value' => 'S (9.5)'];
        $conditions[] = ['group' => 'Lenticule Parameters', 'title' => 'Transition Zone', 'value' => '0.1'];
        $conditions[] = ['group' => 'Lenticule Parameters', 'title' => 'Min Thichkness', 'value' => '15'];
        $conditions[] = ['group' => 'Lenticule Parameters', 'title' => 'Side cut angle', 'value' => '100'];
        $conditions[] = ['group' => 'Cap Parameters', 'title' => 'Diameter', 'value' => '7.7'];
        $conditions[] = ['group' => 'Cap Parameters', 'title' => 'Thichkness', 'value' => '120'];
        $conditions[] = ['group' => 'Cap Parameters', 'title' => 'Side cut angle', 'value' => '90'];
        $conditions[] = ['group' => 'Incision Parameters', 'title' => 'Position', 'value' => '120/60'];
        $conditions[] = ['group' => 'Incision Parameters', 'title' => 'Angle', 'value' => '45'];
        $conditions[] = ['group' => 'Incision Parameters', 'title' => 'Width', 'value' => '3'];

        return $conditions;
    }

    public function surgery_kcn_keratoplasty()
    {
        if (isset($this->globalData['eyeexam_examination_WTW']) && is_numeric($this->globalData['eyeexam_examination_WTW'])) {
            if (isset($this->globalData['patient_grads_type']) && $this->globalData['patient_grads_type'] == 'KCN') {
                $diameter_donor_mm = $this->globalData['eyeexam_examination_WTW'] + 0.25;
            } elseif (isset($this->globalData['patient_grads_type']) && $this->globalData['patient_grads_type'] == 'Normal') {
                $diameter_donor_mm = $this->globalData['eyeexam_examination_WTW'] + 0.5;
            }
        }

        $conditions[] = ['group' => 'WTW', 'title' => 'WTW', 'value' => isset($this->globalData['eyeexam_examination_WTW']) ? $this->globalData['eyeexam_examination_WTW'] : null];
        $conditions[] = ['group' => 'Diameter Host (mm)', 'title' => 'mm', 'value' => isset($this->globalData['eyeexam_examination_WTW']) ? $this->globalData['eyeexam_examination_WTW'] : null];
        $conditions[] = ['group' => 'Diameter Donor (mm)', 'title' => 'mm', 'value' => isset($diameter_donor_mm) ? $diameter_donor_mm : null];
        $conditions[] = ['group' => 'Tickness', 'title' => 'Tickness', 'value' => isset($this->globalData['pachy_min']) ? $this->globalData['pachy_min'] : null];

        return $conditions;
    }

    public function surgery_kcn_cxl()
    {
        $conditions[] = ['group' => 'Pre-Op. Diagnosis', 'title' => 'Pre-Op. Diagnosis', 'value' => ''];
        $conditions[] = ['group' => 'Post-Op. Diagnosis', 'title' => 'Post-Op. Diagnosis', 'value' => ''];
        $conditions[] = ['group' => 'Kind of Operation', 'title' => 'Kind of Operation', 'value' => ''];
        $conditions[] = ['group' => 'Procedure and Findings', 'title' => 'Procedure and Findings', 'value' => ''];
        $conditions[] = ['group' => 'Irradiation intensity', 'title' => 'Irradiation intensity', 'value' => '3mw/cm3 from 5cm'];
        $conditions[] = ['group' => 'Irradiation time', 'title' => 'Irradiation time', 'value' => '30 min'];
        $conditions[] = ['group' => 'Riboflavin', 'title' => 'Riboflavin', 'value' => '0.1%'];
        $conditions[] = ['group' => 'Drop', 'title' => 'Drop', 'value' => 'q 3min×10'];

        return $conditions;
    }

    public function surgery_kcn_ring_keraring()
    {
        if (isset($this->globalData['subjective_ref_sph']) && isset($this->globalData['subjective_ref_cyl']) && isset($this->globalData['type'])) {
            $getKeraringICRS = $this->getKeraringICRS($this->globalData['subjective_ref_cyl'], $this->globalData['subjective_ref_sph'], $this->globalData['type']);
        }

        $conditions[] = ['group' => 'ICRS', 'title' => 'ICRS Thickness', 'value' => isset($getKeraringICRS) && is_array($getKeraringICRS) ? $getKeraringICRS[0] : null];
        $conditions[] = ['group' => 'ICRS', 'title' => 'ICRS Thickness', 'value' => isset($getKeraringICRS) && is_array($getKeraringICRS) ? $getKeraringICRS[1] : null];
        $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc Length (Degrees)', 'value' => '90-210'];
        $conditions[] = ['group' => 'Position', 'title' => 'Position', 'value' => isset($this->globalData['position']) ? $this->globalData['position'] : null];
        $conditions[] = ['group' => 'Depth in Cornea', 'title' => 'um', 'value' => isset($this->globalData['depth_in_cornea']) ? $this->globalData['depth_in_cornea'] : null];
        $conditions[] = ['group' => 'Inner Diameter', 'title' => 'Inner Diameter', 'value' => 6];
        $conditions[] = ['group' => 'Outer Diameter', 'title' => 'Outer Diameter', 'value' => 7];
        $conditions[] = ['group' => 'Arc', 'title' => 'Arc', 'value' => 180];

        return $conditions;
    }

    public function surgery_kcn_ring_feraring()
    {
        if (isset($this->globalData['type']) && ($this->globalData['type'] == 1 || $this->globalData['type'] == 2)) {
            if (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) <= 2) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => 'None/150'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 2 && abs($this->globalData['astig_topo']) <= 4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => 'None/200'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 4 && abs($this->globalData['astig_topo']) <= 6) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => 'None/250'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 6 && abs($this->globalData['astig_topo']) <= 8) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => 'None/300'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 8 && abs($this->globalData['astig_topo']) <= 10) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '150/250'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 10) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '200/300'];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => ''];
            }
        } elseif (isset($this->globalData['type']) && $this->globalData['type'] == 3) {
            if (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) <= 2) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => 'None/150'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 2 && abs($this->globalData['astig_topo']) <= 4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '150/200'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 4 && abs($this->globalData['astig_topo']) <= 6) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '200/250'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 6) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '250/300'];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => ''];
            }
        } elseif (isset($this->globalData['type']) && $this->globalData['type'] == 4) {
            if (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) <= 2) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '150/150'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 2 && abs($this->globalData['astig_topo']) <= 4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '200/200'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 4 && abs($this->globalData['astig_topo']) <= 6) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '250/250'];
            } elseif (isset($this->globalData['astig_topo']) && abs($this->globalData['astig_topo']) > 6) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => '300/300'];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => ''];
            }
        } else {
            $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'ICRS Thickness', 'value' => ''];
        }

        $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => '90-210'];
        $conditions[] = ['group' => 'Position', 'title' => 'Position', 'value' => isset($this->globalData['position']) ? $this->globalData['position'] : null];
        $conditions[] = ['group' => 'Depth in Cornea', 'title' => 'um', 'value' => isset($this->globalData['depth_in_cornea']) ? $this->globalData['depth_in_cornea'] : null];
        $conditions[] = ['group' => 'Inner Diameter', 'title' => 'Inner Diameter', 'value' => 4.8];
        $conditions[] = ['group' => 'Outer Diameter', 'title' => 'Outer Diameter', 'value' => 5.4];
        $conditions[] = ['group' => 'Arc', 'title' => 'Arc', 'value' => 180];

        return $conditions;
    }

    public function surgery_kcn_ring_intacs()
    {
        if (isset($this->globalData['type']) && ($this->globalData['type'] == 3 || $this->globalData['type'] == 4)) {
            if (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= 0.0 && $this->globalData['subjective_ref_sph'] > -1) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 210];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 210];
            } elseif (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= -1 && $this->globalData['subjective_ref_sph'] > -2) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 250];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 250];
            } elseif (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= -2 && $this->globalData['subjective_ref_sph'] > -3) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 300];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 300];
            } elseif (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= -3 && $this->globalData['subjective_ref_sph'] > -4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 350];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 350];
            } elseif (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= -4 && $this->globalData['subjective_ref_sph'] > -5) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 400];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 400];
            } elseif (isset($this->globalData['subjective_ref_sph']) && $this->globalData['subjective_ref_sph'] <= -5) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 450];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 450];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => ''];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => ''];
            }
        } elseif (isset($this->globalData['type']) && ($this->globalData['type'] == 1 || $this->globalData['type'] == 2)) {
            if (isset($this->globalData['subjective_ref_cyl']) && $this->globalData['subjective_ref_cyl'] <= -2.00 && $this->globalData['subjective_ref_cyl'] > -3) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 350];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 210];
            } elseif (isset($this->globalData['subjective_ref_cyl']) && $this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 400];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 210];
            } elseif (isset($this->globalData['subjective_ref_cyl']) && $this->globalData['subjective_ref_cyl'] <= -4) {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => 450];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => 210];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => ''];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => ''];
            }
        } else {
            $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Inferior Intacs (um)', 'value' => ''];
            $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Superior Intacs (um)', 'value' => ''];
        }

        $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
        $conditions[] = ['group' => 'Position', 'title' => 'Position', 'value' => isset($this->globalData['position']) ? $this->globalData['position'] : null];
        $conditions[] = ['group' => 'Depth in Cornea', 'title' => 'um', 'value' => isset($this->globalData['depth_in_cornea']) ? $this->globalData['depth_in_cornea'] : null];
        $conditions[] = ['group' => 'Inner Diameter', 'title' => 'Inner Diameter', 'value' => 6.77];
        $conditions[] = ['group' => 'Outer Diameter', 'title' => 'Outer Diameter', 'value' => 8.1];
        $conditions[] = ['group' => 'Arc', 'title' => 'Arc', 'value' => 180];

        return $conditions;
    }

    public function surgery_kcn_ring_intacs_sk()
    {
        if (isset($this->globalData['subjective_ref_sph']) && isset($this->globalData['subjective_ref_cyl'])) {
            $SEQ = $this->globalData['subjective_ref_sph'] + ($this->globalData['subjective_ref_cyl'] * 0.5);
        }

        if (isset($this->globalData['subjective_ref_sph']) && isset($this->globalData['subjective_ref_cyl']) && isset($this->globalData['type'])) {
            // Sph < 0 & sph > Cyl & type 3 & 4
            if ($this->globalData['subjective_ref_sph'] < 0 && abs($this->globalData['subjective_ref_sph']) > abs($this->globalData['subjective_ref_cyl']) && ($this->globalData['type'] == 3 || $this->globalData['type'] == 4)) {
                if ($SEQ <= 0 && $SEQ > -1) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                } elseif ($SEQ <= -1 && $SEQ > -2) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 250];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 250];
                } elseif ($SEQ <= -2 && $SEQ > -4) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 300];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 300];
                } elseif ($SEQ <= -4 && $SEQ > -6) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 350];
                } elseif ($SEQ <= -6 && $SEQ > -8) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 400];
                } elseif ($SEQ <= -8 && $SEQ > -10) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 450];
                } elseif ($SEQ <= -10) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 500];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 500];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                }

                $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
            } // sph > 0 & type 3 & 4
            elseif (($this->globalData['subjective_ref_sph'] > 0 && $this->globalData['subjective_ref_sph'] <= 3) && ($this->globalData['type'] == 3 || $this->globalData['type'] == 4)) {
                if ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 350];
                } elseif (($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 400];
                } elseif (($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 450];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                }

                $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 90];
            } // Sph < 0 & sph = Cyl & type 1 & 2
            elseif ($this->globalData['subjective_ref_sph'] < 0 && abs($this->globalData['subjective_ref_sph']) == abs($this->globalData['subjective_ref_cyl']) && ($this->globalData['type'] == 1 || $this->globalData['type'] == 2)) {
                if (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -2 && $this->globalData['subjective_ref_cyl'] > -3)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 300];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => ''];
                }
            } // sph > 0 & type 1 & 2
            elseif ($this->globalData['subjective_ref_sph'] > 0 && ($this->globalData['type'] == 1 || $this->globalData['type'] == 2)) {
                if (($this->globalData['subjective_ref_sph'] <= 3 && $this->globalData['subjective_ref_sph'] > 0) && ($this->globalData['subjective_ref_cyl'] <= -2 && $this->globalData['subjective_ref_cyl'] > -3)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 3 && $this->globalData['subjective_ref_sph'] > 0) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 3 && $this->globalData['subjective_ref_sph'] > 0) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 3 && $this->globalData['subjective_ref_sph'] > 0) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 500];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => ''];
                }
            } // sph < 0 & cyl > sph type 1 & 2
            elseif ($this->globalData['subjective_ref_sph'] < 0 && abs($this->globalData['subjective_ref_sph']) < abs($this->globalData['subjective_ref_cyl']) && ($this->globalData['type'] == 1 || $this->globalData['type'] == 2)) {
                if (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -2 && $this->globalData['subjective_ref_cyl'] > -3)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.25) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 500];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.25) && ($this->globalData['subjective_ref_cyl'] <= -2 && $this->globalData['subjective_ref_cyl'] > -3)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 300];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.25) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.25) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.25) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => ''];
                }
            } // sph < 0 & cyl > sph & type 3 & 4
            elseif ($this->globalData['subjective_ref_sph'] < 0 && abs($this->globalData['subjective_ref_sph']) < abs($this->globalData['subjective_ref_cyl']) && ($this->globalData['type'] == 3 || $this->globalData['type'] == 4)) {
                if (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.75) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 90];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.75) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 90];
                } elseif (($this->globalData['subjective_ref_sph'] <= 0 && $this->globalData['subjective_ref_sph'] > -1.75) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 90];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.75) && ($this->globalData['subjective_ref_cyl'] <= -3 && $this->globalData['subjective_ref_cyl'] > -5)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 130];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.75) && ($this->globalData['subjective_ref_cyl'] <= -5 && $this->globalData['subjective_ref_cyl'] > -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 130];
                } elseif (($this->globalData['subjective_ref_sph'] <= -1.75) && ($this->globalData['subjective_ref_cyl'] <= -7)) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 130];
                }
            } // Sph < 0 & sph = Cyl & type 3 & 4
            elseif ($this->globalData['subjective_ref_sph'] < 0 && abs($this->globalData['subjective_ref_sph']) == abs($this->globalData['subjective_ref_cyl']) && ($this->globalData['type'] == 3 || $this->globalData['type'] == 4)) {
                if ($SEQ <= 0 && $SEQ > -1) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 210];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 210];
                } elseif ($SEQ <= -1 && $SEQ > -2) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 250];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 250];
                } elseif ($SEQ <= -2 && $SEQ > -4) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 300];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 300];
                } elseif ($SEQ <= -4 && $SEQ > -6) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 350];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 350];
                } elseif ($SEQ <= -6 && $SEQ > -8) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 400];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 400];
                } elseif ($SEQ <= -8 && $SEQ > -10) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 450];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 450];
                } elseif ($SEQ <= -10) {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => 500];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => 500];
                } else {
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                    $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                }

                $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 150];
            } else {
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
                $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
                $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => ''];
            }
        } else {
            $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 1', 'value' => ''];
            $conditions[] = ['group' => 'ICRS Thickness', 'title' => 'Ring 2', 'value' => ''];
            $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => ''];
        }

        $conditions[] = ['group' => 'Position', 'title' => 'Position', 'value' => isset($this->globalData['position']) ? $this->globalData['position'] : null];
        $conditions[] = ['group' => 'Depth in Cornea', 'title' => 'um', 'value' => isset($this->globalData['depth_in_cornea']) ? $this->globalData['depth_in_cornea'] : null];
        $conditions[] = ['group' => 'Inner Diameter', 'title' => 'Inner Diameter', 'value' => 6];
        $conditions[] = ['group' => 'Outer Diameter', 'title' => 'Outer Diameter', 'value' => 7];
        $conditions[] = ['group' => 'Arc', 'title' => 'Arc', 'value' => 180];

        return $conditions;
    }

    public function surgery_kcn_ring_myoring()
    {
        if (isset($this->globalData['KM_D']) && $this->globalData['KM_D'] < 44) {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => 7];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => 280];
        } elseif (isset($this->globalData['KM_D']) && 44 <= $this->globalData['KM_D'] && $this->globalData['KM_D'] < 48) {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => 6];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => 240];
        } elseif (isset($this->globalData['KM_D']) && 48 <= $this->globalData['KM_D'] && $this->globalData['KM_D'] < 52) {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => 6];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => 280];
        } elseif (isset($this->globalData['KM_D']) && 52 <= $this->globalData['KM_D'] && $this->globalData['KM_D'] < 55) {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => 5];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => 280];
        } elseif (isset($this->globalData['KM_D']) && $this->globalData['KM_D'] >= 55) {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => 5];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => 320];
        } else {
            $conditions[] = ['group' => 'Implant diameter(mm)', 'title' => 'Implant diameter(mm)', 'value' => ''];
            $conditions[] = ['group' => 'Implant thickness(um)', 'title' => 'Implant thickness(um)', 'value' => ''];
        }

        $conditions[] = ['group' => 'Position', 'title' => 'Position', 'value' => isset($this->globalData['position']) ? $this->globalData['position'] : null];
        $conditions[] = ['group' => 'Depth in Cornea', 'title' => 'um', 'value' => isset($this->globalData['depth_in_cornea']) ? $this->globalData['depth_in_cornea'] : null];
        $conditions[] = ['group' => 'ICRS Arc Length (Degrees)', 'title' => 'Arc length', 'value' => 360];
        $conditions[] = ['group' => 'Inner Diameter', 'title' => 'Inner Diameter', 'value' => 5];
        $conditions[] = ['group' => 'Outer Diameter', 'title' => 'Outer Diameter', 'value' => 8];

        return $conditions;
    }
}
