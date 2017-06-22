Navn;ID;Befolkning;Besøk;Periode;Besøkende;Sidevisninger;Besøkslengde;Frafallsprosent;Besøk_per_1000_innbygger;Endring_prosent;Sider_per_besøk;Kategori
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {$e};
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
