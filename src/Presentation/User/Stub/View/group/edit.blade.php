@extends($lp['directory'] . '.' . $lp['theme'] . '.master')

@section('header')
    @parent
@endsection

@section('breadcrumb')
    @include($lp['directory'] . '.' . $lp['theme'] . '.layouts.breadcrumb', [
        'title' => __('Modify group') . ': ' . $department->title,
        'lists' => [
            [
                'link' => '#',
                'name' => $lp['name'],
            ],
            [
                'link' => 'lp.admin.group.index',
                'name' => __('Groups'),
            ],
            [
                'link' => '#',
                'name' => __('Modify group'),
            ],
        ],
    ])
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ route('lp.admin.group.update', $group->id) }}">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $group->title }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="parent">{{ __('Parent') }}</label>
                                <select class="form-control" name="parent_id" id="parent"
                                    placeholder="{{ __('Select a group') }}">
                                    <option></option>
                                    @foreach ($groups as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $group->id ? 'selected' : '' }}>
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary mr-2">{{ __('Submit') }}</button>
                    <a href="{{ route('lp.admin.group.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    @parent
@endsection
