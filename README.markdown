# jetset.php
## Where am I?

Jetset is like a really light version of [Dopplr](http://dopplr.com), which I love, but don't want to use that much, ya know? It's really just one PHP function which is called--you guessed it--`parse_locations`. It accepts an associative array of locations and dates (dates are keys, locations are values), sorts them, and then returns a new array. That new array has a few keys of its own:

- `current`: Where you are right now.
- `previous`: The last place you were.
- `next`: Where you're going.
- `past`: An array of all the places you've been before (not including what's in `previous`).
- `future`: An array of all the places you're going to be (not including what's in `next`).

Each returned item is its *own* array, with two keys: `date` is the location's key in the original array, and `place` is whatever you passed in originally. I'm using city names, but this can be whatever you'd like. Maybe you want some [microformat-friendly fields](http://microformats.org/wiki/adr). Go for it.

I like storing all of these in a Yaml file, parsing that, and passing it to the function, because then I can stay as far away from PHP as possible. Since the array is sorted later, I can be sloppy and dump dates in as I think of them.

That's all. See a live copy of this at [http://johnholdun.com/jetset](http://johnholdun.com/jetset).