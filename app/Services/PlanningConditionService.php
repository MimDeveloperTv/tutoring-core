<?php

namespace App\Services;

use App\Models\Hard\Eye\EyeVariable;
use App\Models\Patient;

class PlanningConditionService
{
    private array $planningData;
   public function __construct($patient_id)
   {
        $this->planningData['od'] = EyeVariable::where('patient_id',$patient_id)->where('eye_type','od')->first()->toArray();
        $this->planningData['os'] = EyeVariable::where('patient_id',$patient_id)->where('eye_type','os')->first()->toArray();
        $this->planningData['age'] = Patient::find($patient_id)->age;
        $this->planningData['eyeExam'] = Patient::find($patient_id)->medical_history;
        foreach (['od','os'] as $eyeType)
        {
            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph'])) {
                $this->planningData[$eyeType]['kr'] = $this->planningData[$eyeType]['subjective_ref_sph'] < 0 ? 0.8 : 1;
            } else {
                $errors[$eyeType]['messages'][] = __('messages.planning_null_KR');
            }

            if (!is_null($this->planningData[$eyeType]['K1_D']) && !is_null($this->planningData[$eyeType]['subjective_ref_sph'])) {
                $this->planningData[$eyeType]['k1_post_op'] = (int)$this->planningData[$eyeType]['K1_D'] + ((int)$this->planningData[$eyeType]['subjective_ref_sph'] * (int)$this->planningData[$eyeType]['kr']);
            } else {
                $this->planningData[$eyeType]['k1_post_op'] = null;
                $errors[$eyeType]['messages'][] = __('messages.planning_null_K1_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && !is_null($this->planningData[$eyeType]['subjective_ref_sph'])) {
                $this->planningData[$eyeType]['k2_post_op'] = (int)$this->planningData[$eyeType]['K2_D'] + ((int)$this->planningData[$eyeType]['subjective_ref_sph'] * (int)$this->planningData[$eyeType]['kr']);
            } else {
                $this->planningData[$eyeType]['k2_post_op'] = null;
                $errors[$eyeType]['messages'][] = __('messages.planning_null_K2_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && !is_null($this->planningData[$eyeType]['subjective_ref_cyl'])) {
                $this->planningData[$eyeType]['maxAbl'] = (int)$this->planningData[$eyeType]['subjective_ref_sph'] < 0 ? (abs($this->planningData[$eyeType]['subjective_ref_sph']) + abs($this->planningData[$eyeType]['subjective_ref_cyl'])) * 13 : (max(abs($this->planningData[$eyeType]['subjective_ref_sph']), abs($this->planningData[$eyeType]['subjective_ref_cyl'])) * 13);
            } else {
                $this->planningData[$eyeType]['maxAbl'] = null;
                $errors[$eyeType]['messages'][] = __('messages.planning_null_maxAbl');
            }
            if (!is_null($this->planningData[$eyeType]['pachy_min']) && !is_null($this->planningData[$eyeType]['maxAbl'])) {
                $this->planningData[$eyeType]['rsb'] = $this->planningData[$eyeType]['pachy_min'] - $this->planningData[$eyeType]['maxAbl'];
            } else {
                $this->planningData[$eyeType]['rsb'] = null;
                $errors[$eyeType]['messages'][] = __('messages.planning_null_rsb');
            }
        }
   }

   public function getErrorMessages() : array
   {
        return [
            'refractive_prk' => $this->planning_refractive_prk(),
            'refractive_transprk' => $this->planning_refractive_transprk(),
            'refractive_lasik' => $this->planning_refractive_femtolasik(),
            'refractive_femtolasik' => $this->planning_refractive_femtolasik(),
            'refractive_smile' => $this->planning_refractive_smile(),
            'refractive_rle' => $this->planning_refractive_rle(),
            'planning_refractive_piol' => $this->planning_refractive_piol(),
            'kcn_cxl' => $this->planning_kcn_cxl(),
            'kcn_ring_intacs' => $this->planning_kcn_ring_intacs(),
            'kcn_ring_intacsSK' => $this->planning_kcn_ring_intacsSK(),
            'kcn_ring_keraring' => $this->planning_kcn_ring_keraring(),
            'kcn_ring_ferrara' => $this->planning_kcn_ring_ferrara(),
            'kcn_ring_Myoring' => $this->planning_kcn_ring_Myoring(),
            'kcn_keratoplasty' => $this->planning_kcn_keratoplasty(),
        ];
   }

    public function planning_refractive_prk()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if (!is_null($this->planningData[$eyeType]['K1_D']) && $this->planningData[$eyeType]['K1_D'] < 38 || $this->planningData[$eyeType]['K1_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 38 || $this->planningData[$eyeType]['K2_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['k1_post_op']) && $this->planningData[$eyeType]['k1_post_op'] < 34 || $this->planningData[$eyeType]['k1_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['k2_post_op']) && $this->planningData[$eyeType]['k2_post_op'] < 34 || $this->planningData[$eyeType]['k2_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && $this->planningData[$eyeType]['subjective_ref_sph'] < -8 || $this->planningData[$eyeType]['subjective_ref_sph'] > 1) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Sphere');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && $this->planningData[$eyeType]['subjective_ref_cyl'] < -6 || $this->planningData[$eyeType]['subjective_ref_cyl'] > 0) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 480) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['maxAbl']) && $this->planningData[$eyeType]['maxAbl'] > 125) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_maxAbl');
            }

            if (!is_null($this->planningData[$eyeType]['rsb']) && $this->planningData[$eyeType]['rsb'] < 400) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_rsb');
            }

            if ($this->planningData['age'] < 18) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $errors;
    }

    public function planning_refractive_transprk()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if (!is_null($this->planningData[$eyeType]['K1_D']) && $this->planningData[$eyeType]['K1_D'] < 38 || $this->planningData[$eyeType]['K1_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 38 || $this->planningData[$eyeType]['K2_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['k1_post_op']) && $this->planningData[$eyeType]['k1_post_op'] < 34 || $this->planningData[$eyeType]['k1_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['k2_post_op']) && $this->planningData[$eyeType]['k2_post_op'] < 34 || $this->planningData[$eyeType]['k2_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && $this->planningData[$eyeType]['subjective_ref_sph'] < -8 || $this->planningData[$eyeType]['subjective_ref_sph'] > -3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Sphere');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && $this->planningData[$eyeType]['subjective_ref_cyl'] < -6 || $this->planningData[$eyeType]['subjective_ref_cyl'] > 0) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 500) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['maxAbl']) && $this->planningData[$eyeType]['maxAbl'] > 185) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_maxAbl');
            }

            if (!is_null($this->planningData[$eyeType]['rsb']) && $this->planningData[$eyeType]['rsb'] < 400) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_rsb');
            }

            if ($this->planningData['age'] < 18) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $errors;
    }

    public function planning_refractive_femtolasik()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if (!is_null($this->planningData[$eyeType]['K1_D']) && $this->planningData[$eyeType]['K1_D'] < 38 || $this->planningData[$eyeType]['K1_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 38 || $this->planningData[$eyeType]['K2_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['k1_post_op']) && $this->planningData[$eyeType]['k1_post_op'] < 34 || $this->planningData[$eyeType]['k1_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['k2_post_op']) && $this->planningData[$eyeType]['k2_post_op'] < 34 || $this->planningData[$eyeType]['k2_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && $this->planningData[$eyeType]['subjective_ref_sph'] < -10 || $this->planningData[$eyeType]['subjective_ref_sph'] > 6) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Sphere');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && $this->planningData[$eyeType]['subjective_ref_cyl'] < -6 || $this->planningData[$eyeType]['subjective_ref_cyl'] > 0) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 500) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['maxAbl']) && $this->planningData[$eyeType]['maxAbl'] > 140) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_maxAbl');
            }

            if (!is_null($this->planningData[$eyeType]['rsb']) && $this->planningData[$eyeType]['rsb'] < 290) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_rsb');
            }

            if ($this->planningData['age'] < 18) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_refractive_smile()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if (!is_null($this->planningData[$eyeType]['K1_D']) && $this->planningData[$eyeType]['K1_D'] < 38 || $this->planningData[$eyeType]['K1_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 38 || $this->planningData[$eyeType]['K2_D'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['k1_post_op']) && $this->planningData[$eyeType]['k1_post_op'] < 34 || $this->planningData[$eyeType]['k1_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K1_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['k2_post_op']) && $this->planningData[$eyeType]['k2_post_op'] < 34 || $this->planningData[$eyeType]['k2_post_op'] > 48) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2_post_op');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_sph']) && $this->planningData[$eyeType]['subjective_ref_sph'] < -10 && $this->planningData[$eyeType]['subjective_ref_sph'] > -0.5) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Sphere');
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && $this->planningData[$eyeType]['subjective_ref_cyl'] < -5 || $this->planningData[$eyeType]['subjective_ref_cyl'] > 0) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 500) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['maxAbl']) && $this->planningData[$eyeType]['maxAbl'] > 150) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_maxAbl');
            }

            if (!is_null($this->planningData[$eyeType]['rsb']) && $this->planningData[$eyeType]['rsb'] < 250) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_rsb');
            }

            if ($this->planningData['age'] < 18) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_refractive_rle()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] < 40) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $errors;
    }

    public function planning_refractive_piol()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 40) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (!is_null($this->planningData[$eyeType]['ac_depth']) && $this->planningData[$eyeType]['ac_depth'] < 3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_AcDepth');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $errors;
    }

    public function planning_kcn_cxl()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 35) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 8) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 8) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 400) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['KM_D']) && $this->planningData[$eyeType]['KM_D'] > 58) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Km');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['diabetes'] == true) {
                $errors['global']['messages'][] = __('messages.diabetes');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_ring_ferrara()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (strpos($this->planningData[$eyeType]['optometry_ucva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['optometry_ucva']);
                if ($sph[0] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['optometry_ucva'] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && abs($this->planningData[$eyeType]['subjective_ref_cyl']) > 3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 300) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['Axis_flat']) && abs($this->planningData[$eyeType]['Axis_flat'] - (int)$this->planningData[$eyeType]['subjective_ref_axis']) > 15) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Axis');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_ring_keraring()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (strpos($this->planningData[$eyeType]['optometry_ucva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['optometry_ucva']);
                if ($sph[0] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['optometry_ucva'] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && abs($this->planningData[$eyeType]['subjective_ref_cyl']) > 3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 250) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['Axis_flat']) && abs((int)$this->planningData[$eyeType]['Axis_flat'] - (int)$this->planningData[$eyeType]['subjective_ref_axis']) > 15) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Axis');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_ring_intacs()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (strpos($this->planningData[$eyeType]['optometry_ucva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['optometry_ucva']);
                if ($sph[0] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['optometry_ucva'] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && abs($this->planningData[$eyeType]['subjective_ref_cyl']) > 3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 450) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['Axis_flat']) && abs((int)$this->planningData[$eyeType]['Axis_flat'] - (int)$this->planningData[$eyeType]['subjective_ref_axis']) > 15) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Axis');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_ring_intacsSK()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (strpos($this->planningData[$eyeType]['optometry_ucva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['optometry_ucva']);
                if ($sph[0] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['optometry_ucva'] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['subjective_ref_cyl']) && abs($this->planningData[$eyeType]['subjective_ref_cyl']) < 3) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Cyl');
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 450) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['K2_D']) && $this->planningData[$eyeType]['K2_D'] < 55) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_K2');
            }

            if (!is_null($this->planningData[$eyeType]['Axis_flat']) && abs((int)$this->planningData[$eyeType]['Axis_flat'] - (int)$this->planningData[$eyeType]['subjective_ref_axis']) > 15) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Axis');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_ring_Myoring()
    {
        $errors = [];
        foreach (['od', 'os'] as $eyeType) {
            if ($this->planningData['age'] > 50) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Age');
            }

            if (strpos($this->planningData[$eyeType]['subjective_ref_bcva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['subjective_ref_bcva']);
                if ($sph[0] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['subjective_ref_bcva'] > 9) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_BCVA');
                }
            }

            if (strpos($this->planningData[$eyeType]['optometry_ucva'], '/') !== false) {
                $sph = explode('/', $this->planningData[$eyeType]['optometry_ucva']);
                if ($sph[0] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            } else {
                if ($this->planningData[$eyeType]['optometry_ucva'] > 3) {
                    $errors[$eyeType]['messages'][] = __('messages.planning_errors_UCVA');
                }
            }

            if (!is_null($this->planningData[$eyeType]['pachy_min']) && $this->planningData[$eyeType]['pachy_min'] < 360) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_PachyMin');
            }

            if (!is_null($this->planningData[$eyeType]['KM_D']) && $this->planningData[$eyeType]['KM_D'] < 44) {
                $errors[$eyeType]['messages'][] = __('messages.planning_errors_Km');
            }
        }

        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }

            if ($this->planningData['eyeExam']['recurrent_corneal_erosion'] == true) {
                $errors['global']['messages'][] = __('messages.recurrent_corneal_erosion');
            }
        }

        return $errors;
    }

    public function planning_kcn_keratoplasty()
    {
        $errors = [];
        if ($this->planningData['eyeExam']) {
            // Global
            if ($this->planningData['eyeExam']['collagen_systemic_diseases'] == true) {
                $errors['global']['messages'][] = __('messages.collagen_systemic_dlseases');
            }

            if ($this->planningData['eyeExam']['lactation'] == true) {
                $errors['global']['messages'][] = __('messages.lactation');
            }

            if ($this->planningData['eyeExam']['pregnancy'] == true) {
                $errors['global']['messages'][] = __('messages.pregnancy');
            }

            if ($this->planningData['eyeExam']['or_steroids'] == true) {
                $errors['global']['messages'][] = __('messages.or_steroids');
            }

            if ($this->planningData['eyeExam']['or_isotretinoin'] == true) {
                $errors['global']['messages'][] = __('messages.or_isotretinoin');
            }

            if ($this->planningData['eyeExam']['or_immunosuppressant'] == true) {
                $errors['global']['messages'][] = __('messages.or_lmmunosuppresant');
            }

            if ($this->planningData['eyeExam']['or_sumatriptan'] == true) {
                $errors['global']['messages'][] = __('messages.or_sumatriptan');
            }
        }

        return $errors;
    }
}
