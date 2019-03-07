USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_wb_totals_grp]    Script Date: 1/30/2017 3:51:57 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO






CREATE procedure [dbo].[llu_wb_totals_grp] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'hospital';


select
'Totals:' as splitname,
s.display_name as name,
sum(staffed) as staffed,
sum(available) as available,
sum(other) as other,
sum(waiting) as waiting,
max(oldest) as oldest_sec,
case 
	when sum(offered) = 0 then 0
	else
		round( (100*(sum(cast(acceptable as float)) / sum(cast((offered) as float)))), 1)
end as svclvl,
cast((cast(max(oldest) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(max(oldest) as int)%60) as varchar(2)),2) as oldest
from rt_split r inner join split_groups s on r.split=s.split
where s.param=@grpName
group by s.display_name





GO

