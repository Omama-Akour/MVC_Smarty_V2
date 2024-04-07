{foreach $subcategories as $subcategory}
    <option value="{$subcategory->id}">{$prefix} {$subcategory->category_name}</option>
    {if isset($subcategory->sub) && is_array($subcategory->sub) && !empty($subcategory->sub) && $depth > 0}
        {include file='categories/subCategories.tpl' subcategories=$subcategory->sub prefix=($prefix|cat:'-') depth=$depth-1}
    {/if}
{/foreach}
