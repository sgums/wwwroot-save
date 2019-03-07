USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_wb_totals]    Script Date: 1/30/2017 3:51:46 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


--SET QUOTED_IDENTIFIER ON
--GO





CREATE procedure [dbo].[llu_wb_totals] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'operations';


select
'Totals:' as splitname,
(select distinct display_name from split_groups where param=@grpName) as name,
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
from rt_split
where split in (select split from split_groups where param=@grpName);





GO

