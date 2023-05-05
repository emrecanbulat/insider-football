@extends('layouts.app')
@section('title', 'Tournament Teams')
@section('content')

    <div class="container-fluid py-4">
        <div class="row content-center">
            <div class="col-6 ">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Tournament Teams</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Logo
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Team
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <img src="{{$team->logo}}" class="avatar avatar-xs me-3 border-radius-lg" alt="user1">
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$team->name}}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="block-header block-header-rtl">
                    <a href="{{route("fixture.index")}}" class="btn btn-success">Generate Fixtures</a>
                </div>
            </div>
        </div>
    </div>


@endsection
