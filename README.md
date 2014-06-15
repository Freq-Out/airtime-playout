airtime-playout
===============

This is an example of how to display a playout history for Airtime.

##PgSQL Request

Basically, what you want to display, at GMT+1 (Paris, winter time) is, as a PgSQL request:

```sql
SELECT to_char(cc_schedule.starts + time '01:00','HH24:MI:SS') AS broadcast_time,
cc_files.track_title,
cc_files.artist_name,
cc_files.album_title 
FROM cc_files 
INNER JOIN cc_schedule 
ON cc_files.id=cc_schedule.file_id 
WHERE cc_schedule.media_item_played = 't' 
ORDER BY cc_schedule.starts 
DESC LIMIT 2
```

This will display the broadcasted time (trimmed of its year/month/day because we don't care), adapted to the Paris timezone (GMT+2 at the time of this writing), then the title, artist and album name.


| broadcast_time  | track_title   | artist_name   | album_title   | 
| -------------   | :----------:  | :----------:  | :----------:  |
| 23:27:20        | Title Powa  	| Babar Tist    | Anal Bum      | 
| 23:24:49        | Patrack       | Anar Tist     | Bootleg       |

Once you have your table, skin it as you like (CSS, JS etc.).



