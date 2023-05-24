<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>{{$menu->name}}</h1>
            <div class="bc-pages">
                @if(isset($links[0]) && $links[0]['route']!='dashboard')
                    <a href="{{validRouteUrl('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                @endif
                @foreach($links as $link)
                    <a href="{{routeIsExist($link['route'])?validRouteUrl($link['route']):''}}">{{$link['name']}}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>
