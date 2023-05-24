<!DOCTYPE html>
<html>

<head>
    <title>Document Player</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <style>
        iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
<div class="responsive-container">
    @if ($lesson->host == 'Word')
        <iframe src="https://docs.google.com/gview?url={{ asset($lesson->video_url) }}&embedded=true"></iframe>
    @endif
    @if ($lesson->host == 'Excel' || $lesson->host == 'PowerPoint' || $lesson->host == 'PPT' || $lesson->host == 'PPTX')
        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ asset($lesson->video_url) }}"></iframe>
    @endif
    @if ($lesson->host == 'Text')
        <iframe src="{{ asset($lesson->video_url) }}"></iframe>
    @endif
    @if ($lesson->host == 'Iframe')
        @if (!empty($lesson->video_url))
            <iframe class="video_iframe" id="video-id" src="{{ asset($lesson->video_url) }}"></iframe>
        @endif
    @endif
</div>
</body>

</html>
