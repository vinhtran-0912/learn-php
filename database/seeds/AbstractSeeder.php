<?php

use Illuminate\Database\Seeder;

/**
 * Base class for seeder with csv.
 */
abstract class AbstractSeeder extends Seeder
{
    protected $validateColumn = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    abstract public function run();

    public function createDataFromCSV($fileName)
    {
        $dataArray = Excel::toArray(null, $fileName, null, \Maatwebsite\Excel\Excel::CSV)[0];

        $column = $dataArray[0];
        unset($dataArray[0]);
        $dataArray = array_values($dataArray);

        return [
            'column' => $column,
            'data' => $dataArray,
        ];
    }

    public function createInsertData(array $value, array $columnArray)
    {
        $value = array_map(function ($v) {
          return strtolower($v) == 'null' ? null : $v;
        }, $value);

        $value = array_combine($columnArray, $value);

        if (!empty($this->columnValidate)) {
          foreach ($this->columnValidate as $key) {
            $validateValue[$key] = $value[$key];
            unset($value[$key]);
          }
        } else {
          $validateValue['id'] = $value['id'];
          unset($value['id']);
        }

        $value['created_at'] = $value['updated_at'] = Carbon\Carbon::now()->toDateTimeString();

        if (isset($value['password'])) {
          $value['password'] = bcrypt($value['password']);
        }

        return [
          'validate' => $validateValue,
          'value' => $value,
        ];
    }

    /**
     * insertData
     *
     * @param  array $data
     * @param  string $tableName
     *
     * @return void
     */
    public function insertData($data, $tableName)
    {
        foreach ($data['data'] as $value) {
            $insertData = $this->createInsertData($value, $data['column']);

            DB::table($tableName)->updateOrInsert($insertData['validate'], $insertData['value']);
        }
    }
}
