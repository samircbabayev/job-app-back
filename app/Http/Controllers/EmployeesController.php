<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 2 * 60);

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\ImportHistory;

class EmployeesController extends Controller
{
    public function batchImport(Request $request)
    {
        if ($binaryData = $request->getContent()) {
           
            $data = array_map('str_getcsv', explode("\n", $binaryData));

            $employees = [];

            foreach ($data as $key => $row) {
                if (!$key) continue;

                if($row[0]) {

                    try {
                        $dateOfBirth = Carbon::createFromFormat('m/d/Y', $row[7])->toDateString();
                    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                        $dateOfBirth = NULL;
                    }
                    
                    try {
                        $timeOfBirth = Carbon::createFromFormat('h:i:s A', $row[8])->toTimeString();
                    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                        $timeOfBirth = NULL;
                    }
                    
                    try {
                        $joinTime = Carbon::createFromFormat('m/d/Y', $row[10])->toDateString();
                    } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                        $joinTime = NULL;
                    }                    

                    $employees[$row[0]] = [
                        'employee_id' => $row[0],
                        'name_prefix' => $row[1],
                        'first_name' => $row[2],
                        'middle_initial' => $row[3],
                        'last_name' => $row[4],
                        'gender' => $row[5],
                        'email' => $row[6],
                        'birth_date' => $dateOfBirth,
                        'birth_time' => $timeOfBirth,
                        'date_of_birth' => $row[7],
                        'time_of_birth' => $row[8],
                        'age_in_years' => $row[9],
                        'join_time' => $joinTime,
                        'date_of_joining' => $row[10],
                        'age_in_company_years' => $row[11],
                        'phone' => $row[12],
                        'place_name' => $row[13],
                        'country' => $row[14],
                        'city' => $row[15],
                        'zip' => $row[16],
                        'region' => $row[17],
                        'username' => $row[18],
                        'deleted_at' => NULL,
                    ];
                }
            }
            $employees = array_values($employees);

            if ($employees) {
                $importHistory = ImportHistory::create([
                    'result_count' => count($employees),
                ]);
    
                foreach ($employees as $key => $values) {
                    $employees[$key]['import_id'] = $importHistory->id;
                }

                
                $chunkSize = 1500;
                $totalRecords = count($employees);

                for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
                    $chunk = array_slice($employees, $i, $chunkSize);

                    Employee::upsert(
                        $chunk,
                        ['employee_id']
                    );
                }

                return response()->json(['message' => 'Import successful']);
            }
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function index(Request $request)
    {
        $employees = Employee::orderBy('created_at', 'desc')->where('deleted_at',null)->paginate(2000);
        return response()->json($employees);
    }

    public function details($id, Request $request)
    {
        $employee = Employee::where('employee_id', $id)->whereNull('deleted_at')->first();

        if(!$employee) {
            return response()->json([
                'code' => 204,
                'message' => 'Employee not found'
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'data' => $employee,
        ]);
    }

    public function delete($id, Request $request)
    {
        $employee = Employee::where('employee_id', $id)->whereNull('deleted_at')->first();

        if(!$employee) {
            return response()->json([
                'code' => 204,
                'message' => 'Employee not found'
            ]);
        }

        $employee->delete(); 

        return response()->json([
            'code' => 200,
            'message' => 'Employee deleted'
        ]);
    }
}
