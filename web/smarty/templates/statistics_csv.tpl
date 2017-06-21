Navn{"\t"}ID{"\t"}Befolkning{"\t"}Besøk{"\t"}Periode{"\t"}visitors{"\t"}Sidevisninger{"\t"}Besøkslengde{"\t"}Frafallsprosent{"\t"}Besøk per 1k innbygger{"\t"}Endring prosent{"\t"}Sider per besøk{"\t"}category
{strip}
{foreach from=$data item=site}
 {foreach from=$site item=line}
  {foreach from=$line item=e}
   {$e}{"\t"}
  {/foreach}{"\n"}
 {/foreach}
{/foreach}
{/strip}
