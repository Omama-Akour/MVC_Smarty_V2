{extends file='layouts/app.tpl'}

{block name='title'}Edit category{/block}

{block name='contents'}
    <h1 class="mb-0">Edit category</h1>
    <hr />
    <form action="/mvcdashboard/categories/update?id={$category->id}" method="POST">
        {* <input type="hidden" name="csrf_token" value="{$csrfToken}"> *}
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="category_name" class="form-control" placeholder="Category Name" value="{$category->category_name}" >
            </div>
            <div class="col mb-3">
                <label class="form-label">Parent Category</label>
                <select name="parent_category" id="parent_category" class="form-control">
                    <option value="">No Parent</option>
                    {foreach $categories as $parentCategory}
                        <option value="{$parentCategory->id}" {if $parentCategory->id eq $category->parent_id}selected{/if}>
                            {$parentCategory->category_name}
                        </option>
                        {if $parentCategory->sub|@count gt 0}
                            {include file='categories/subCategories.tpl' subcategories=$parentCategory->sub prefix='-'}
                        {/if}
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
{/block}
