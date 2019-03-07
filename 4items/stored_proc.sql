USE [tester]
GO

/****** Object:  StoredProcedure [dbo].[fourItemsSP]    Script Date: 8/29/2015 7:57:47 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


ALTER procedure [dbo].[fourItemsSP] (@spl int)
as

select top 1
split as Split,
splitname as 'Split_Name',
inqueue as Waiting,
cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as Oldest,
available as Available,
case 
	when offered = 0 then 100
else
	cast(100*(cast(acceptable as decimal(18,2)) / cast(offered as decimal(18,2))) as decimal(18,1))
end as 'Service_Level'
from fourItems
where split=@spl


GO


