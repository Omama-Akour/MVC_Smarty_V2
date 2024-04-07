{extends file="layouts/app.tpl"}

{block name=title}
    Create Content
{/block}

{block name=contents}
    <h1 class="mb-0">Add Content</h1>
    <hr />
    <form action="/mvcdashboard/contents/store" method="POST" enctype="multipart/form-data">
        {* Ensure to include any CSRF token if required *}
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="Title" class="form-label">Content Title</label>
                <input type="text" name="content_title" class="form-control" id="Title" placeholder="Content Name">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="textarea_content" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="textarea_content"></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <label for="category_id" class="form-label"> Category</label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">No Parent</option>
                {foreach $categories as $category}
                    {if is_array($category)}
                        <option value="{$category['id']}">{$category['category_name']}</option>
                    {else}
                        <option value="{$category->id}">{$category->category_name}</option>
                    {/if}
                    {if isset($category['sub']) && is_array($category['sub'])}
                        {include file='categories/subCategories.tpl' subcategories=$category['sub'] prefix='-'}
                    {/if}
                {/foreach}
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="enable" id="enable">
                    <label class="form-check-label" for="enable">
                        Enable
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        ClassicEditor
            .create(document.querySelector('#textarea_content'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    // Update the hidden input field value
                    document.getElementById('textarea_content').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
{/block}
