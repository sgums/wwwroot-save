USE [cms]
GO

/****** Object:  StoredProcedure [dbo].[medline_desktop_middle]    Script Date: 1/11/2017 7:46:19 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO





CREATE procedure [dbo].[medline_desktop_middle] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'Self_Pay';


select
splitname,
staffed,
available,
other,
waiting,
abncalls,
acdcalls,
offered,
oldest as oldest_sec,
case 
	when offered = 0 then 0
	else
		round( (100*(cast(acceptable as float) / cast(offered as float))), 1)
end as svclvl,
cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as oldest,
case
	when acdcalls = 0 then '0:00'
	else 
		cast((cast((anstime/acdcalls) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((anstime/acdcalls) as int)%60) as varchar(2)),2)
end as asa
from rt_split
where split in (select split from split_groups where group_name=@grpName);




GO


