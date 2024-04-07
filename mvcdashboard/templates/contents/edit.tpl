{extends file="layouts/app.tpl"}

{block name=title}
    Edit Content
{/block}

{block name=contents}
    <h1 class="mb-0">Edit Content</h1>
    <hr />
    <form action="/mvcdashboard/contents/update?id={$content.id}" method="POST">
    <input type="hidden" name="id" value="{$content.id}">
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Content Title</label>
            <input type="text" name="content_title" class="form-control" value="{$content.content_title}">
        </div>
        <div class="col mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control">
                {foreach $categories as $category}
                    <option value="{$category.id}" {if $category.id == $content.category_id}selected{/if}>
                        {$category.category_name}
                    </option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Added By</label>
            <input type="text" name="added_by" class="form-control" value="{$content.added_by}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Added Date</label>
            <input type="text" name="added_date" class="form-control" value="{$content.added_date}" readonly>
        </div>
    </div>
   
    <div class="row mb-3">
    <div class="col-md-12">
        <label for="textarea_content" class="form-label">Content</label>
        <textarea class="form-control" name="content" id="textarea_content" class="form-control">{$content.content}></textarea>
    </div>
</div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary">Update</button>
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
