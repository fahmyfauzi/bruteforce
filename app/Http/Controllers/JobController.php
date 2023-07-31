<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\Category;

class JobController extends Controller
{
    public function index()
    {
        // mengubah huruf menjadi kecil
        $search = strtolower(request('search'));
        $jobs = [];

        // memeriksa apakah parameter search ada atau tidak
        if ($search) {
            // Mengambil waktu awal pencarian
            $startTime = microtime(true);

            //--------------------------------------------------------------------------
            // mendapatkan semua lowongan kerja dari database dengan relasi

            // $jobs = Jobs::where('title', 'LIKE', '%' . $search . '%')->latest()->get();

            $jobs = Jobs::with(['category', 'company', 'author'])->latest()->get();

            $filteredJobs = [];


            // Loop through each job
            foreach ($jobs as $job) {
                // mengubah huruf menjadi kecil
                $title = strtolower($job->title);

                // Lakukan pencarian secara brute force
                for ($i = 0; $i <= strlen($title) - strlen($search); $i++) {
                    $j = 0;

                    // Cocokkan karakter pada pola dengan karakter pada teks
                    while ($j < strlen($search) && $title[$i + $j] == $search[$j]) {
                        $j++;
                    }

                    // Jika seluruh karakter pada pola cocok dengan karakter pada teks, maka ditemukan pola pada teks.
                    if ($j == strlen($search)) {
                        $filteredJobs[] = $job->id;
                        break;
                    }
                }
            }

            // Get jobs based on filtered jobs
            $jobs = Jobs::whereIn('id', $filteredJobs)->latest()->get();

            //--------------------------------------------------------------------------

            // Mengambil waktu akhir pencarian
            $endTime = microtime(true);
            $executionTimeInMilliseconds = ($endTime - $startTime) * 1000;

            // Menghitung selisih waktu pencarian dalam milidetik
            $executionTime = number_format($executionTimeInMilliseconds / 1000, 2);
        } else {
            // memeriksa jika parameter search tidak ada maka akan menampilkan semua lowongan kerja dengan paginasi
            $jobs = Jobs::with(['category', 'company', 'author'])->latest()->paginate(20);
            $executionTime = 0;
        }

        return view('job.index', [
            'jobs' => $jobs,
            'categories' => Category::all(),
            'search_job' => request('search'),
            'found_job' => count($jobs),
            'execution_time' => $executionTime
        ]);
    }






    public function show(Jobs $job)
    {

        return view('job.show', [
            'categories' => Category::all(),
            'job' => $job,
            'jobs' => Jobs::where('user_id', $job->author->id)->latest()->take(7)->get(),


        ]);
    }
}
