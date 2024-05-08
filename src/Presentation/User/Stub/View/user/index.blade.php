@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Users'),
        'lists' => [
            [
                'url' => $lp['dashboard_url'],
                'name' => $lp['name'],
            ],
            [
                'url' => '#',
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
                        class="btn btn-outline-primary btn-icon-text float-right mb-2 btn-sm">
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
                                    <td> {{ $item->id }} </td>
                                    <td> {{ $item->first_name . ' ' . $item->last_name }} </td>
                                    <td> {{ $item->email }} </td>
                                    <td> {{ $item->mobile }} </td>
                                    <td> {{ $item->status }} </td>
                                    <td> {{ $item->created_at }} </td>
                                    <td>
                                        @foreach ($item->roles as $value)
                                            <span>{{ $value->name }}</span>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($item->groups as $gr)
                                            @foreach ($gr->groups as $group)
                                                <span>{{ $group->name }}</span>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('lp.admin.user.edit', $item->id) }}"
                                            class="btn btn-outline-dark btn-sm">
                                            <i class="mdi mdi-pencil-box-outline text-primary"></i>
                                            {{ __('Edit') }}</a>

                                        <form action="{{ route('lp.admin.user.delete', $item->id) }}" method="post"
                                            class="inline-block btn btn-sm">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="mdi mdi-delete-forever"></i>
                                                {{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    {{ $users->links() }}
@endsection

@section('footer')
    @parent
@endsection
