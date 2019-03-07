USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[last10weeks]    Script Date: 1/30/2017 3:50:30 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO












CREATE procedure [dbo].[last10weeks] (@grp varchar(20))
as

--declare @grp varchar(20);
--set @grp = 'hospital';

declare @dow int;
set @dow = datepart(dw, getdate());

declare @maxDate smalldatetime;
set @maxDate = dateadd(ww,-10,getdate());


with intervalsum (starttime, offered) as
(
select
starttime,
sum(callsoffered) offered
from split_history
where datepart(dw,row_date)=@dow and row_date >= @maxDate
and split in (select split from split_groups where param=@grp)
group by row_date, starttime
)
select 
 starttime,
 avg(offered) as offered
 from intervalsum
 group by starttime
 order by starttime





--select
--starttime,
--avg(callsoffered) as offered
--from split_history
--where datepart(dw,row_date)=@dow  and row_date >= @maxDate
--and split = @spl
--group by starttime

--having datepart(dw,row_date)=@dow
--order by starttime;










GO

