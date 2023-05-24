<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/popular_instructor.jpg')}}"
     data-aoraeditor-title="Popular Instructor" data-aoraeditor-categories="Instructor Page">
    <div class="instractors_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section__title2 mb_76">
                        <span>{{__('frontend.Popular Instructors')}}</span>
                        <h4>{{__('frontend.Making sure that our products exceed customer expectations')}}
                            <br>{{__('frontend.for quality, style and performance')}}.</h4>
                    </div>
                </div>
            </div>


            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table="users"
                 data-select="image,name,id,headline,total_rating"
                 data-order="total_rating"
                 data-dir="desc"
                 data-limit="4"
                 data-view="_single_instructor"
                 data-model=""
                 data-with=""
                 data-with-count=""
                 data-where-role_id="2"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>


        </div>
    </div>
</div>
