@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Groups'),
        'lists' => [
            [
                'url' => $lp['dashboard_url'],
                'name' => $lp['name'],
            ],
            [
                'url' => '#',
                'name' => __('Groups'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('lp.admin.group.create') }}"
                        class="btn btn-outline-primary btn-icon-text btn-sm float-right mb-2">
                        <i class="mdi mdi-shape-rectangle-plus btn-icon-prepend"></i>
                        {{ __('New Group') }}
                    </a>
                    <h4 class="card-title">{{ __('List of groups') }}</h4>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> {{ __('Title') }} </th>
                                <th> {{ __('Parent') }} </th>
                                <th> {{ __('Actions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $item)
                                <tr>
                                    <td> {{ $item->id }} </td>
                                    <td> {{ $item->title }} </td>
                                    <td> {{ $item->parent ? $item->parent->title : '----' }} </td>
                                    <td class="text-right">
                                        <a href="{{ route('lp.admin.group.edit', $item->id) }}"
                                            class="btn btn-outline-dark btn-sm">
                                            <i class="mdi mdi-pencil-box-outline text-primary"></i>
                                            {{ __('Edit') }}</a>

                                        <form action="{{ route('lp.admin.group.delete', $item->id) }}" method="post"
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
    {{ $groups->links() }}
@endsection

@section('footer')
    @parent
@endsection
