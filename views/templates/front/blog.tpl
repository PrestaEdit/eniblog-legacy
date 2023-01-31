{* /modules/eniblog/views/templates/front/blog.tpl *}
{extends file=$layout}

{block name="left_column"}
    <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
        {hook h="displayLeftColumnBlog"}
        <ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Food
    <span class="badge badge-info badge-pill">14</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Dapibus ac facilisis in
    <span class="badge badge-info badge-pill">2</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    Morbi leo risus
    <span class="badge badge-info badge-pill">1</span>
  </li>
</ul>
    </div>
  {/block}

{block name="content"}
    <div class="row">
        <div class="col-md-12">
            <div class="blog-card bg-white mb-4 overflow-hidden d-lg-flex rounded-lg position-relative">
                <div class="blog-image overflow-hidden d-flex align-items-center">
                    <img src="https://dev.presta-module.com/jonathan/8.0.0/modules/eniblog/views/img/posts/1.jpg" alt=""
                        class="blog-thumbnail">
                </div>
                <div class="p-4 blog-container">
                    <a href="#!" class="blog-category text-uppercase py-1 px-2 rounded-lg">
                        <small class="font-weight-bold">Food</small>
                    </a>
                    <h4 class="mt-2 font-weight-bold">
                        <a href="#!" class="text-dark" title="Agriculture is good for both humans and animals">Agriculture
                            is good for both humans and animals</a>
                    </h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt, ullam,
                        reprehenderit? Praesentium doloribus soluta, quia.</p>
                    <div class="blog-footer d-flex justify-content-between align-items-center border-top">
                        <div>
                            <a href="#!" class="text-dark">Jonathan Danse</a>
                        </div>
                        <small class="text-muted">Sep 18, 2022</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="blog-card bg-white mb-4 overflow-hidden d-lg-flex rounded-lg position-relative">
                <div class="blog-image overflow-hidden d-flex align-items-center">
                    <img src="https://dev.presta-module.com/jonathan/8.0.0/modules/eniblog/views/img/posts/1.jpg" alt=""
                        class="blog-thumbnail">
                </div>
                <div class="p-4 blog-container">
                    <a href="#!" class="blog-category text-uppercase py-1 px-2 rounded-lg">
                        <small class="font-weight-bold">Food</small>
                    </a>
                    <h4 class="mt-2 font-weight-bold">
                        <a href="#!" class="text-dark" title="Agriculture is good for both humans and animals">Agriculture
                            is good for both humans and animals</a>
                    </h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt, ullam,
                        reprehenderit? Praesentium doloribus soluta, quia.</p>
                    <div class="blog-footer d-flex justify-content-between align-items-center border-top">
                        <div>
                            <a href="#!" class="text-dark">Jonathan Danse</a>
                        </div>
                        <small class="text-muted">Sep 18, 2022</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}