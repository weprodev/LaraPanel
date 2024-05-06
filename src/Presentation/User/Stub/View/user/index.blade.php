@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Users'),
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => '#',
                'name' => __('Users'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('lp.admin.user.create') }}"
                        class="btn btn-outline-primary btn-icon-text float-right btn-newInList">
                        <i class="mdi mdi-account-plus btn-icon-prepend"></i>
                        {{ __('New user') }}
                    </a>
                    <h4 class="card-title">{{ __('List of users') }}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Full Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Mobile') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Register Date') }}</th>
                                <th>{{ __('Roles') }}</th>
                                <th>{{ __('Groups') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr
                                    class="{{ $item->status == 'blocked' ? ' bg-warning ' : '' }} {{ $item->status == 'deleted' ? ' bg-danger ' : '' }}">
                                    <td>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->first_name . ' ' . $item->last_name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>
                                        {{ $item->mobile }}
                                    </td>
                                    <td>
                                        {{ $item->status }}
                                    </td>
                                    <td>
                                        {{ $item->created_at }}
                                    </td>
                                    <td>
                                        {{-- @forelse ($item->roles as $value)
                                            {{ $value->name }},
                                        @empty
                                            ----
                                        @endforelse --}}
                                    </td>
                                    <td>
                                        {{-- @forelse ($item->departments as $value)
                                            {{ $value->title }},
                                        @empty
                                            ----
                                        @endforelse --}}
                                    </td>
                                    <td>
                                        {{-- @if ($item->status == 'deleted')
                                            <form action="{{ route('admin.user_management.user.restore', $item->id) }}"
                                                method="post" class="inline-block">
                                                @method('PUT')
                                                {{ csrf_field() }}
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">Restore</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.user_management.user.edit', $item->id) }}"
                                                class="btn btn-outline-dark btn-sm">Edit</a>

                                            <form action="{{ route('admin.user_management.user.delete', $item->id) }}"
                                                method="post" class="inline-block">
                                                @method('DELETE')
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form> --}}
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
