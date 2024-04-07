{extends file='layouts/app.tpl'}

{block name='title'}Create category{/block}

{block name='contents'}
    <h1 class="mb-0">Add category</h1>
    <hr />
    <form action="/mvcdashboard/categories/store" method="POST" enctype="multipart/form-data">
        {* <input type="hidden" name="csrf_token" value="{$csrfToken}"> *}
        
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="category_name" class="form-control" placeholder="Category Name">
            </div>
            <div class="col">
                <select name="parent_category" id="parent_category" class="form-control">
                    <option value="">No Parent</option>
                    {foreach $categories as $category}
                        <option value="{$category->id}">{$category->category_name}</option>
                        {if isset($category->sub) && is_array($category->sub) && !empty($category->sub)}
                            {include file='categories/subCategories.tpl' subcategories=$category->sub prefix='-' depth=1}
                        {/if}
                    {/foreach}
                </select>
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
{/block}
