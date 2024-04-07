{extends file='layouts/app.tpl'}

{block name='title'}Home category{/block}

{block name='contents'}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">List category</h1>
        <a href="/mvcdashboard/categories/create" class="btn btn-primary">Add category</a>
    </div>
    <hr class="mb-4">

    <!-- Search Form -->
    <form action="/mvcdashboard/categories" method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Search by category name" class="form-control">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Table -->
    <table class="table-auto w-full border">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Category Name</th>
                <th class="px-4 py-2">Parent Category</th>
                <th class="px-4 py-2">Contents Count</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            {if isset($categories) && $categories|@count gt 0}
                {foreach $categories as $category}
                    <tr>
                        <td class="px-4 py-2">{$category->id}</td>
                        <td class="px-4 py-2">{$category->category_name}</td>
                        <td class="px-4 py-2">{if $category->parent_id}{$category->category_name}{else}No Parent{/if}</td>
                        <td class="px-4 py-2">{$category->contents_count}</td>
                        <td class="px-4 py-2">
                            <div class="btn-group">
                                <a href="/mvcdashboard/categories/edit?id={$category->id}" class="btn btn-warning">Edit</a>
                                <a href="/mvcdashboard/categories/destroy?id={$category->id}" class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <td class="text-center" colspan="5">Category not found</td>
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
