{extends file="layouts/app.tpl"}

{block name=title}
    Home content
{/block}

{block name=contents}
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List content</h1>
        <a href="/mvcdashboard/contents/create" class="btn btn-primary">Add content</a>
    </div>
    <hr />

    <!-- Search Form -->
    <form action="/mvcdashboard/contents" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by title" value="{if isset($request.search)}{$request.search}{/if}">
                </div>
            </div>
            <div class="col-md-3">  
                <div class="form-group">
                    <select name="category_id" class="form-control">
                        <option value="" selected>Select Category</option>
                        {foreach $categories as $category}
                            <option value="{$category.id}">{$category.category_name}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    {if isset($success)}
        <div class="alert alert-success" role="alert">
            {$success}
        </div>
    {/if}

    <!-- Table to display content -->
    <table class="table table-hover">
        <!-- Table headers -->
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Content Title</th>
                <th>Category</th>
                <th>Added Date</th>
                <th>Added By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {if $contents|@count > 0}
                {foreach $contents as $content}
                    <tr>
                        <td class="align-middle">{$content.id}</td>
                        <td class="align-middle">{$content.content_title}</td>
                        <td class="align-middle">{$content.category_name}</td>
                        <td class="align-middle">{$content.added_date}</td>
                        <td class="align-middle">{$content.added_by}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="/mvcdashboard/contents/edit?id={$content.id}" type="button" class="btn btn-warning">Edit</a>
                                <a href="/mvcdashboard/contents/destroy?id={$content.id}" type="button" class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <td class="text-center" colspan="6">Content not found</td>
                </tr>
            {/if}
        </tbody>
    </table>
<!-- Pagination -->
<div class="flex justify-center mt-4">
{if isset($pagination)}
    <ul class="pagination">
        {foreach $pagination as $page}
            {if is_array($page)}
                <li {if isset($page.current) && $page.current}class="active"{/if}>
                    <a href="{$page.url}">{$page.num}</a>
                </li>
            {else}
                {* Debug information *}
                {* <pre>{$page|@print_r}</pre> *}
                {* End of debug information *}
            {/if}
        {/foreach}
    </ul>
{/if}
</div>

{/block}
