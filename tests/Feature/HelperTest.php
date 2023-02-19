<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelperTest extends TestCase
{

    /**
     * @dataProvider usdToRupiahDataProviders
     */
    public function testUsdToRupiahFormatConverterInputZero(mixed $input, string $output)
    {
        $this->assertEquals(usd_to_rp($input), $output);
    }

    public function usdToRupiahDataProvider()
    {
        return [
            [null, 'Rp 0,00'],
            [0, 'Rp 0,00'],
            [1, 'Rp 14.000,00'],
            [10, 'Rp 140.000,00'],
            [20, 'Rp 280.000,00'],
            ['string', 'Rp 0,00'],
        ];
    }



}
