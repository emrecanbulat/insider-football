@extends('layouts.app')
@section('title', 'Fixtures')
@section('content')

    <div class="container-fluid py-4">
        <div class="row content-center">
            @foreach($fixtures as $key => $fixture)
                <div class="col-4">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-secondary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">{{"Week ". $key +1}}</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Homeowner
                                        </th>
                                        <th>
                                            &#8203;
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Displacement
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fixture as $fix)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{$teams->where("id",$fix[0])->first()->name}}
                                                </p>
                                            </td>
                                            <td>
                                                <p>
                                                    -
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{$teams->where("id",$fix[1])->first()->name}}
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
            @endforeach
        </div>
    </div>

@endsection
