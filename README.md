parallel-flickr 🐼
==
  
parallel-flickr is a tool for backing up your Flickr photos and generating a database backed website that honours the viewing permissions you've chosen on Flickr. parallel-flickr is **not** a replacement for Flickr.

parallel-flickr is still a work in progress. It ain't pretty or classy yet but it works. **It almost certainly still contains bugs, some of them really stupid.**

It still needs to be documented properly.

In the meantime, [here's a blog post](http://www.aaronland.info/weblog/2011/10/14/pixelspace/#parallel-flickr) and [some screenshots](http://www.flickr.com/photos/straup/tags/parallelflickr/).

Installing parallel-flickr
--

The Easy Way (local VM only, for now)
--

* Install Vagrant (http://vagrantup.com/)

  $> gem install vagrant

* Install VirtualBox: https://www.virtualbox.org/

* Create the VM

  $> vagrant up

* Setup the database

  http://localhost:8080/god/setup.php

The Somewhat Harder Way
--

* First, some basic OS-level setup:

	v$> sudo apt-get install git-core

	v$> git clone git@github.com:straup/parallel-flickr.git

	v$> cd parallel-flickr

	v$> sudo sh ./ubuntu/install.sh

	v$> sudo chown -R www-data templates_c

	TO DO: apache configs

    $> cd schema

    $> mysql -u root -p < SETUP.md

    $> cat *schema | mysql -u root -p flickr

* Now set up the application config file:

	$> cp www/include/config.php.example www/include/config.php

	TO DO: updating the config file, see also: https://github.com/straup/flamework-tools/blob/master/bin/make-project.sh 

* That's it.

Backing up photos
--
After setting up everything above, and setting your API key callback to "http://YOURDOMAINNAME.com/auth/", visit /account/backups/. This will
create your backup user account and then from here you can run the various backup scripts inside of the bin/ directory. 

Keeping up to date
--
It is helpful to set these various bin/backup_* scripts to run via cron. According to your level of faving, uploading, and contacts fiddling, you may have your own requirements for often you want to run the various backup scripts.

Here's my a once-a-day example, which works for a moderate level of activity:

    0 3 * * * php /full/path/to/parallel-flickr/bin/backup_contacts.php
    15 3 * * * php /full/path/to/parallel-flickr/bin/backup_faves.php
    30 3 * * * php /full/path/to/parallel-flickr/bin/backup_photos.php

TO DO:
--

* write files to S3 (see also: [flamework-aws](https://github.com/straup/flamework-aws))

* make sure video files are actually being fetched properly

* API hooks (see also: [flamework-api](https://github.com/straup/flamework-api))

* sets, galleries, groups

* uploads (and then re-uploading to Flickr (see above inre: API hooks))

* dates and timezones... sad face (also something is currrently _very_
  squirrel-y with the way dates are being indexed in parallel-flickr-solr but I
  haven't been able to figure out what/why yet (20111125))

* photo deletion

* account deletion

* cron jobs for backups

* consider moving all the backup jobs (fetching data for individual photos) in to a proper queuing system - this should probably be a feature flag so that the whole thing can still be run in "stupid" mode and not spiral in to astronaut territory.

* context-specific URLs (e.g. in-faves or in-WOEID)

* display metadata

* search, see also: [parallel-flickr-solr](https://github.com/straup/parallel-flickr-solr)

* better layout, tested in more than just Firefox

See also: [TODO.txt](https://github.com/straup/parallel-flickr/blob/master/TODO.txt)

To note:
--

* password reminders are disabled, only because I don't have a mail server set up

A note about (Github) branches:
--

If you look carefully you may see that there are a lot branches for
parallel-flickr in my Github repository. These are there purely (and only) for
my working purposes.

You're welcome to poke at them obviously but the rule of thumb is: If it's in
"master" then it should work, modulo any outstanding bugs. If it's in any other
branch then all the usual caveats apply, your mileage may vary and we offer no
guarantees or refunds.

See also:
--

* [flamework](https://github.com/straup/flamework)

* [flamework-flickrapp](https://github.com/straup/flamework-flickrapp)

* [flamework-api](https://github.com/straup/flamework-api)

* [flamework-invitecodes](https://github.com/straup/flamework-invitecodes)

* [flamework-tools](https://github.com/straup/flamework-tools)
