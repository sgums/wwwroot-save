USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_wb_grp]    Script Date: 1/30/2017 3:51:30 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO







CREATE procedure [dbo].[llu_wb_grp] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'hospital';


select
r.split,
s.display_name,
splitname,
staffed,
available,
other,
waiting,
oldest as oldest_sec,
case 
	when offered = 0 then 0
	else
		round( (100*(cast(acceptable as float) / cast((offered) as float))), 1)
end as svclvl,
cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as oldest
from rt_split r inner join split_groups s on r.split=s.split
where s.param=@grpname
order by waiting desc, oldest desc, svclvl






GO

