<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/all_section.jpg')}}"
    data-aoraeditor-title="All Section" data-aoraeditor-categories="Home Page">
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_category_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_instructor_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_course_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_best_category_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_quiz_section'))  </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">

            @include(theme('snippets.components._home_page_testimonial_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_sponsor'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_blog_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_become_instructor_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_how_to_buy'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_faq'))
        </div>
    </div>

</div>

@include(theme('snippets.components._home_page_banner'))
@include(theme('snippets.components._home_page_slider'))
@include(theme('snippets.components._home_page_category_section'))
@include(theme('snippets.components._home_page_instructor_section'))
@include(theme('snippets.components._home_page_course_section'))
@include(theme('snippets.components._home_page_best_category_section'))
@include(theme('snippets.components._home_page_quiz_section'))
@include(theme('snippets.components._home_page_testimonial_section'))
@include(theme('snippets.components._home_sponsor'))
@include(theme('snippets.components._home_page_blog_section'))
@include(theme('snippets.components._home_page_become_instructor_section'))
@include(theme('snippets.components._home_page_how_to_buy'))
@include(theme('snippets.components._home_page_faq'))
