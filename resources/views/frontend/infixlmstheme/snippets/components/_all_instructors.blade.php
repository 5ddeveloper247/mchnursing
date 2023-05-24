<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/instructor_list.jpg')}}"
     data-aoraeditor-title="Instructor List" data-aoraeditor-categories="Instructor Page">
    <div class="instractors_wrapper instractors_wrapper2">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section__title2 mb_76">
                        <span>{{__('frontend.Meet Our world-class instructors')}}</span>
                        <h4>{{__('frontend.We are here to meet your demand and teach the most beneficial way for you in Personal')}}
                            .</h4>
                    </div>
                </div>
            </div>


            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="users"
                 data-select="image,name,id,headline"
                 data-order="id"
                 data-limit=""
                 data-view="_single_instructor"
                 data-model=""
                 data-with=""
                 data-pagination="16"
                 data-where-role_id="2"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>


        </div>
    </div>
</div>
