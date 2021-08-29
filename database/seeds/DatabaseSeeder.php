<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        App\DateType::truncate();
        App\Event::truncate();
        App\Eventinstrumentation::truncate();
        App\Geostate::truncate();
        App\Honorific::truncate();
        App\Instrumentation::truncate();
        App\Organization::truncate();
        App\Parentguardiantype::truncate();
        App\Person::truncate();
        App\Pronoun::truncate();
        App\School::truncate();
        App\Shirtsize::truncate();
        App\Student::truncate();
        App\Teacher::truncate();
        App\User::truncate();
        App\Version::truncate();
        App\VersionDate::truncate();

        DB::table('school_student')->truncate();
        DB::table('school_teacher')->truncate();
        DB::table('student_teacher')->truncate();
        DB::table('statustypes')->truncate();


        $this->call([
            DateTypeSeeder::class,
            EventSeeder::class,
            EventInstrumentationSeeder::class,
            GeoStatesSeeder::class,
            PronounsTableSeeder::class,
            HonorificsSeeder::class,
            InstrumentationSeeder::class,
            ShirtSizeSeeder::class,
            StatustypesSeeder::class,
            OrganizationSeeder::class,
            ParentguardiantypeSeeder::class,
            PronounsTableSeeder::class,
            SchoolSeeder::class,
            PeopleSeeder::class,
            VersionSeeder::class,
            VersionDateSeeder::class,
            ]);
    }
}
