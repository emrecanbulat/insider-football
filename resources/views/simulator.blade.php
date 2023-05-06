@extends('layouts.app')
@section('title', 'Tournament Teams')
@section('content')

    <div class="container-fluid py-4">
        <div class="row content-center">
            <div class="col-6">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Team
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Points
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Played
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Win
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Drawn
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Lost
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Goal Diff
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <div class="d-flex px-3 py-1">
                                                <img src="{{$team->logo}}" class="avatar avatar-xs me-3 border-radius-lg" alt="user1">
                                            </div>
                                        </td>
                                        <td >
                                            <p class="text-xs font-weight-bold mb-0">{{$team->name}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->points}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->played}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->win}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->drawn}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->lost}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{$team->goal_dif}}</p>
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
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Week 1</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Home Team
                                    </th>
                                    <th>
                                        &#8203;
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Away Team
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fixture as $fix)
                                    <tr>
                                        <td>
                                            <p class="align-middle text-center text-xs font-weight-bold mb-0">
                                                {{$teams->where("id",$fix->home_team_id)->first()->name}}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="align-middle text-center">
                                                -
                                            </p>
                                        </td>
                                        <td>
                                            <p class="align-middle text-center text-xs font-weight-bold mb-0">
                                                {{$teams->where("id",$fix->away_team_id)->first()->name}}
                                            </p>
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
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Championship Prodictions</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Team
                                    </th>
                                    <th>
                                        &#8203;
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxl font-weight-bolder opacity-7 ps-2">
                                        %
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>
                                            <p class="align-middle text-center text-xs font-weight-bold mb-0">
                                                {{$team->name}}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="align-middle text-center">
                                                -
                                            </p>
                                        </td>
                                        <td>
                                            <p class="align-middle text-center text-xs font-weight-bold mb-0">
                                               0
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 ">
            <a class="btn btn-success">Play All Weeks</a>
            <a class="btn btn-behance">Play Next Week</a>
            <a onclick="$.delete()"  class="btn btn-danger">Reset Data</a>
        </div>
    </div>


@endsection

@section('js')

    <script>
        $(document).ready(function () {
            $.delete = function () {
                $.confirm({
                    title: 'Reset Data',
                    content: '' +
                        '<p>Are you sure you want to continue? This action cannot be undone?</p>',
                    buttons: {
                        formSubmit: {
                            text: 'Delete',
                            btnClass: 'btn-danger',
                            action: function () {
                                $.ajax({
                                    url: '{{route('reset-data')}}',
                                    type: "GET",
                                    success: function (res) {
                                        if (res) {
                                            window.location = '/';
                                        } else {
                                            $.dialog({
                                                title: 'Error!',
                                                content: "Please try again.",
                                            });
                                        }
                                    }
                                });

                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            action: function () {
                                //close
                            }
                        }
                    },
                });
            }


        });

    </script>

@endsection
