@extends('template.template_dashboard')

@section('title', 'Lists Users')

@section('head')

@endsection

@section('content-back')

    <div class="card">  
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $user->name }}</span>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $user->email }}</span>
                            </td>
                          

                            
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
