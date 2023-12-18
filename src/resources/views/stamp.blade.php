@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/stamp.css') }}" />
@endsection


@section('content')

<div class="content">
    <div class=content_message>さんお疲れ様です！</div>
    <div class="content_stamp">
        <form class="stamp_frame" action="" method="">
            <button class="start_time-button" type="submit">勤務開始</button>
        </form>

        <form class="stamp_frame" action="" method="">
            <button class="end_time-button" type="submit">勤務終了</button>
        </form>

        <form class="stamp_frame" action="" method="">
            <button class="break_start_time-button" type="submit">休憩開始</button>
        </form>

        <form class="stamp_frame" action="" method="">
            <button class="break_end_time-button" type="submit">休憩終了</button>
        </form>
    </div>
</div>

@endsection

