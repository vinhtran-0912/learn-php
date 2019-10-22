<?php

class UsersTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->createDataFromCSV('users.csv');
        $this->insertData($data, 'users');
    }
}
