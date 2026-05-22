<?php

namespace Database\Seeders;

use App\Models\DestinationType;
use Illuminate\Database\Seeder;

class DestinationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'more a pláž',
            'hory a príroda',
            'historické mestá',
            'mestský výlet',
            'aktivity a dobrodružstvo',
        ];

        foreach ($types as $type) {
            DestinationType::updateOrCreate(['name' => $type]);
        }
    }
}
