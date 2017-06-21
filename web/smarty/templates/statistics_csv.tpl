Navn{"\t"}ID{"\t"}Befolkning{"\t"}Besøk{"\t"}Periode{"\t"}Besøkende{"\t"}Sidevisninger{"\t"}Besøkslengde{"\t"}Frafallsprosent{"\t"}Besøk_per_1000_innbygger{"\t"}Endring_prosent{"\t"}Sider_per_besøk{"\t"}category
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {$e}{"\t"}
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
