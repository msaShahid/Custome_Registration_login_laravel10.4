<?php

namespace App\Http\Controllers\API;

use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class getApiDataController extends Controller{

    public function apiData(){
        try {
            $apiLink = 'https://jsonplaceholder.typicode.com/posts/';

            $dataResponse = Http::get($apiLink,);

            // Check if the request was successful
            if ($dataResponse->successful()) {
                $responseData = $dataResponse->json(); // Convert the response body to JSON

                // Assuming API data in DB
                foreach ($responseData as $postData){
                    $post = new post();
                    $post->title = $postData['title'];
                    $post->body = $postData['body'];
                    $post->save();
                };

                return response()->json(['status'=>'Success','message'=>'Data save in Database successfully !!']);

               // return response()->json(['status' => 'Success','data' => $responseData], 200);
            } else {
                // Handle non-successful response
                return response()->json(['status' => 'Failed','message' => 'Error while getting data from API'], $dataResponse->status());
            }
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json([ 'status' => 'Failed','message' => 'An error occurred: ' . $e->getMessage()], 500);
        }


        /*
            $apiLink = 'https://jsonplaceholder.typicode.com/posts';

            $dataResponse = Http::get($apiLink);

            // Check if the data was retrieved successfully
            if ($dataResponse->successful()) {
                $data = json_decode($dataResponse->body(), true);

                // Batch size for insertion
                $batchSize = 1000;

                // Calculate the number of batches
                $totalRecords = count($data);
                $totalBatches = ceil($totalRecords / $batchSize);

                // Insert data into the database in batches
                try {
                    for ($i = 0; $i < $totalBatches; $i++) {
                        $batchData = array_slice($data, $i * $batchSize, $batchSize);

                        // Using chunk to insert data in smaller batches
                        Post::insert($batchData);

                        // Calculate progress
                        $progress = min(($i + 1) * $batchSize, $totalRecords);

                        // Update response with progress information
                        $response = [
                            'status' => 'Processing',
                            'message' => "Processed $progress out of $totalRecords records",
                        ];

                        // Return the response to update the client
                        echo json_encode($response);
                        ob_flush();
                        flush();
                    }

                    return response()->json(['status' => 'Success', 'message' => 'Data inserted into the database successfully'], 200);
                } catch (\Exception $e) {
                    // Handle the exception and return an error response
                    return response()->json(['status' => 'Failed', 'message' => 'Error while saving data to the database', 'error' => $e->getMessage()], 500);
                }
            } else {
                return response()->json(['status' => 'Failed', 'message' => 'Error while getting data from API'], 400);
            }



        
        */

    }

    public function getApiData(){

       $postList =  post::limit(10)->get();

        return view('userDashboard.apiDatalist',compact('postList'));
    }


// Controller end here....
}
