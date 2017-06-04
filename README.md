# phpmud2
This is my second iteration at building a PHP browser-based MUD (Multi-user dungeon).

This is a far better implementation than I was doing before, and I think worth the entire redo. 

This time, we're using an SQLite database. I really wanted to be able to implement an ORM, which just doesn't work well with jquery objects. However, I still wanted the light weight and portability that comes with local files, so sqlite and activerecord seemed perfect, and it does work perfectly. 

The autoloading is now actual PSR-4 autoloading through composer, so everything you need is available inside the react loop.
The react loop is also accessible inside the game interface, allowing us to pretend that PHP is a threaded language.
