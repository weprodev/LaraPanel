@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => 'Roles',
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => '#',
                'name' => __('Roles'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('lp.admin.role.create') }}"
                        class="btn btn-outline-primary btn-icon-text float-right btn-newInList">
                        <i class="mdi mdi-settings btn-icon-prepend"></i>
                        {{ __('New role') }}
                    </a>
                    <h4 class="card-title">{{ __('List of roles') }}</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> {{ __('Role') }} </th>
                                <th> {{ __('Title') }} </th>
                                <th> {{ __('Guard name') }} </th>
                                <th> {{ __('Description') }} </th>
                                <th> {{ __('Actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td> {{ $item->id }} </td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->title }} </td>
                                    <td> {{ $item->guard_name }} </td>
                                    <td> {{ $item->description }} </td>
                                    <td>
                                        <a href="{{ route('lp.admin.role.edit', $item->id) }}"
                                            class="btn btn-outline-dark btn-sm">{{ __('Edit') }}</a>

                                        <form action="{{ route('lp.admin.role.delete', $item->id) }}" method="post"
                                            class="inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm">{{ __('Delete') }}</button>
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
@endsection


@section('footer')
    @parent
@endsection
