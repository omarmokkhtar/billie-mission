<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class BillieMissionTest extends TestCase
{

    public function testUtcTimeValidation()
    {
        $this->json('GET', 'api/get-mars-data', [])
            ->assertStatus(422)
            ->assertJsonStructure(['message']);
    }

    public function testIsDataReturnedSuccessfully()
    {
            $entryTime = Carbon::now();

            $this->json('GET', 'api/get-mars-data?entryTime=' . $entryTime)
            ->assertOk()
            ->assertJsonStructure([
                    'marsSolDate',
                    'coordinatedMarsTime',
            ]);
    }

    public function testWrongUTCTimeFormat()
    {
        $entryTime = Carbon::now()->format('Y-m-d');

        $this->json('GET', 'api/get-mars-data?entryTime=' . $entryTime)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
}
