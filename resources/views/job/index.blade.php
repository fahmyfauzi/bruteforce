@extends('layouts.app')
@section('title')
    Lowongan Pekerjaan
@endsection
@section('content')
    <!--Page Title-->
    <section class="page-title style-three">
        <div class="auto-container">
            <!-- Job Search Form -->
            <div class="job-search-form">
                <form action="/job">
                    <div class="row">
                        <!-- Form Group -->

                        <div class="form-group col-lg-10 col-md-12 col-sm-12">

                            <span class="icon flaticon-search-1"></span>
                            <input type="text" name="search" id="search" placeholder="Job title"
                                value="{{ old('search', $search_job) }}">

                        </div>


                        <!-- Form Group -->

                        {{--
          <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
            <span class="icon flaticon-map-locator"></span>
            <input type="text" name="location" placeholder="City or postcode">
          </div> --}}


                        <!-- Form Group -->


                        {{-- <div class="form-group col-lg-3 col-md-12 col-sm-12 category">
              <span class="icon flaticon-briefcase"></span>
              <select class="chosen-select" name="category">
                <option selected disabled>Select Category</option>
                @foreach ($categories as $item)
                @if (old('category') == $item->slug)
                <option value="{{ $item->slug }}" selected>{{ $item->name }}</option>
                @else
                <option value="{{ $item->slug }}">{{ $item->name }}</option>
                @endif
                @endforeach
              </select>
            </div> --}}


                        <!-- Form Group -->
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                            <button type="submit" class="theme-btn btn-style-one">Find Jobs</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Job Search Form -->

        </div>
    </section>
    <!--End Page Title-->

    <!-- Listing Section -->
    <section class="ls-section style-three">
        <div class="auto-container">
            <div class="filters-backdrop"></div>

            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-12">
                    @if (request('search'))
                        <p>Algoritma Brute Foce</p>
                        <p>Ditemukan : {{ $found_job }} </p>
                        <p>Lama Pencarian : {{ $execution_time }} ms</p>
                    @endif
                    <div class="ls-outer">
                        <!-- ls Switcher -->
                        {{-- <div class="ls-switcher">
            <div class="showing-result">
            </div>

            <div class="sort-by">
              <select class="chosen-select">
                <option>New Jobs</option>
                <option>Freelance</option>
                <option>Full Time</option>
                <option>Internship</option>
                <option>Part Time</option>
                <option>Temporary</option>
              </select>

            </div>
          </div> --}}
                        <div class="row">
                            @forelse ($jobs as $job)
                                <div class="job-block-two col-lg-12">
                                    <div class="inner-box">
                                        <div class="content">
                                            <span class="company-logo"><img
                                                    src="{{ asset('storage/' . $job->company->logo) }}" alt=""></span>
                                            <h4><a href="/job/{{ $job->slug }}">{{ $job->title }}</a></h4>
                                            <ul class="job-info">
                                                <li><a href="job?category={{ $job->category->slug }}"><span
                                                            class="icon flaticon-briefcase"></span>
                                                        {{ ucfirst($job->category->name) }}</a></li>
                                                <li><a href="/job?location={{ $job->location }}"><span
                                                            class="icon flaticon-map-locator"></span>
                                                        {{ $job->location }}</a></li>
                                                <li><span class="icon flaticon-clock-3"></span>
                                                    {{ $job->created_at->diffForHumans() }}</li>
                                                <li><span class="icon flaticon-money"></span>{{ $job->salary }}</li>
                                            </ul>
                                        </div>
                                        <ul class="job-other-info">
                                            <li class="time"><a
                                                    href="/job?type={{ Str::slug($job->type, '-') }}">{{ $job->type }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <h1 class="text-center">Maaf data yang anda cari belum tersedia</h1>
                            @endforelse


                        </div>
                        <!-- Listing Show More -->
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            @if (!request('search'))
                                {{ $jobs->links('vendor.pagination.bootstrap-5') }}
                            @endif
                        </div>
                        {{-- <nav class="ls-pagination">
            <ul>
              <li class="prev"><a href="#"><i class="fa fa-arrow-left"></i></a></li>
              <li><a href="#">1</a></li>
              <li><a href="#" class="current-page"></a></li>
              <li><a href="#">3</a></li>
              <li class="next"><a href="#"><i class="fa fa-arrow-right"></i></a></li>
            </ul>
          </nav> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Listing Page Section -->
@endsection
