@extends('layouts.app')
@section('title', 'Tournament Teams')
@section('content')

    <div class="container-fluid py-4">
        <div class="row content-center">
            <div class="col-7">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Tournament Teams</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="standings" style="width: 100%">
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
                                        Goal For
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Goal Against
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Goal Diff
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

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
                            <h6 class="text-white text-capitalize ps-3" id="week" data-week="1">
                                Week {{$currentWeek}}</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="fixture" style="width: 100%">
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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Championship Prodictions</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="prodictions" style="width: 100%">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Team
                                    </th>
                                    <th>
                                        &#8203;
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        %(Chance)
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 ">
            <button onclick="$.playAll()" class="btn btn-success" id="playAll">Play All Weeks</button>
            <button onclick="$.playNext()" class="btn btn-behance" id="playNext">Play Next Week</button>
            <button onclick="$.delete()" class="btn btn-danger">Reset Data</button>
        </div>
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function () {
            let currentWeek = {{$currentWeek}};
            let fixtureEnds = {{$fixtureEnds}};

            if (currentWeek === fixtureEnds) {
                $('#playAll').hide();
                $('#playNext').hide();
            }

            $('#standings').DataTable({
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "paging": false,
                "processing": true,
                "serverSide": true,
                "info": false,
                "ajax": {
                    url: "{{route('get-teams')}}",
                    type: 'GET'
                },
                'columns': [
                    {
                        data: null, className: 'text-center', render: function (data) {
                            return '<div class="d-flex px-3 py-1">' +
                                '<img src="' + data.logo + ' " class="avatar avatar-xs me-3 border-radius-lg" alt="user1">'
                            '</div>'
                        }
                    },
                    {data: 'name', className: 'text-center'},
                    {data: 'points', className: 'text-center'},
                    {data: 'played', className: 'text-center'},
                    {data: 'win', className: 'text-center'},
                    {data: 'drawn', className: 'text-center'},
                    {data: 'lost', className: 'text-center'},
                    {data: 'goal_for', className: 'text-center'},
                    {data: 'goal_against', className: 'text-center'},
                    {data: 'goal_dif', className: 'text-center'},
                ]
            });

            $('#fixture').DataTable({
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "paging": false,
                "processing": true,
                "serverSide": true,
                "info": false,
                "ajax": {
                    url: "{{route('get-fixture')}}",
                    type: 'GET'
                },
                'columns': [
                    {data: 'home_team.0.name', className: 'text-center'},
                    {
                        data: null, className: 'text-center', render: function (data) {
                            return "-"
                        }
                    },
                    {data: 'away_team.0.name', className: 'text-center'},
                ]
            });

            $('#prodictions').DataTable({
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "paging": false,
                "processing": true,
                "serverSide": true,
                "info": false,
                "ajax": {
                    url: "{{route('get-prodictions')}}",
                    type: 'GET'
                },
                'columns': [
                    {data: 'name', className: 'text-center'},
                    {
                        data: null, className: 'text-center', render: function (data) {
                            return "-"
                        }
                    },
                    {data: 'chance', className: 'text-center'},
                ]
            });

            $.playAll = function () {
                $('#playNext').prop('disabled', true)
                $('#playAll').prop('disabled', true)
                let i = 0;
                setInterval(function () {
                    while (i < fixtureEnds) {
                        $.playNext()
                        i++;
                    }
                }, 1000);
            }

            $.playNext = function () {
                $.ajax({
                    url: '{{route('play-match')}}',
                    type: "GET",
                    data: {
                        week: currentWeek
                    },
                    success: function (res) {
                        if (res && (currentWeek < fixtureEnds)) {
                            currentWeek += 1;
                            $('#week').text("Week " + currentWeek);
                            $('#week').attr('data-week', currentWeek);
                        } else {
                            $.dialog({
                                title: 'Info!',
                                content: "fixture completed, no new match can be played",
                            });
                            $('#playNext').prop('disabled', true)
                            $('#playAll').prop('disabled', true)
                        }
                        $('#standings').DataTable().ajax.reload();
                        $('#fixture').DataTable().ajax.reload();
                        $('#prodictions').DataTable().ajax.reload();
                    }
                })
            }

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
