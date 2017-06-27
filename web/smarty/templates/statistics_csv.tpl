Navn;ID;Befolkning;Besøk;Periode;Besøkende;Sidevisninger;Besøkslengde;Frafallsprosent;Besøk_per_1000_innbygger;Endring_prosent;Sider_per_besøk;Kategori
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {if $e@index eq 0}
   {$e};
   {else}
   ={$e*1000}/1000;
   {/if}
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
