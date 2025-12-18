@extends('app')

@section('title', 'Profile view')

@section('style')

@endsection

@section('content')
    <div class="row justify-content-between">
        <h4 class="mb-4 col-md-12">Profile view</h4>
        <div class="card-body col-md-12">
            <div class="row g-3">
                <div class="col-md-4">
                    @if ($user->photo == null)
                        <img src="{{ asset('images/default.jpg') }}" class="img-thumbnail" alt="{{ $user->name }}">
                    @else
                        <img src="{{ asset('images/' . $user->photo) }}" class="img-thumbnail" alt="{{ $user->name }}">
                    @endif
                </div>
                <div class="col-md-8">


                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>Name</strong>
                            <p class="text-muted mb-0">{{ $user->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Email</strong>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Address</strong>
                            <p class="text-muted mb-0">{{ $user->address }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Country</strong>
                            <p class="text-muted mb-0">{{ $user->country->country_name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>City</strong>
                            <p class="text-muted mb-0">{{ $user->city->city_name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Gender</strong>
                            <p class="text-muted mb-0 text-capitalize">{{ $user->gender }}</p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('edit.user', $user->id) }}" class="btn btn-primary px-4">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
