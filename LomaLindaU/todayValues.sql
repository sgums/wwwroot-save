USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[todayValues]    Script Date: 1/30/2017 3:54:00 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO








CREATE procedure [dbo].[todayValues] (@grp varchar(20))
as

--declare @grp varchar(20);
--set @grp = 'operations';


declare @cdate varchar(15);
set @cdate = convert (varchar(15),getdate(),1);

select
starttime,
sum(callsoffered) as offered
from split_history
where row_date=@cdate
and split in (select split from split_groups where param=@grp)
group by starttime
order by starttime;




GO

