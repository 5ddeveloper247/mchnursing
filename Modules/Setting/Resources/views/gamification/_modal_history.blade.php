<div class="QA_section QA_section_heading_custom check_box_table">
    <div class="QA_table ">
        <table class="table" id="table_id">
            <thead>
            <tr>
                <th>{{__('common.SL')}}</th>
                <th>{{__('common.Type')}}</th>
                <th>{{__('common.Points')}}</th>
                <th>{{__('common.Date')}}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($details as $key=>$item)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{str_replace('_',' ',$item->type)}}</td>
                    <td>{{$item->point}}</td>
                    <td>{{showDate($item->created_at)}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">{{__('common.No data available in the table')}}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>


</script>
