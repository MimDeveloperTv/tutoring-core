<?php

namespace App\DataTransferObjects;

class DomainDTO
{
    public function __construct(
        public string $domain,
        public string $db_database,
        public string $db_username,
        public ?string $db_password,
        public string $api_key,
        public string $app_name = "Cloud Clinic",
    )
    {
    }
}
