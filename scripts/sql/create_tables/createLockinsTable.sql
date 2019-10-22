-- The script used to create the users table
CREATE TABLE IF NOT EXISTS lockins (
  id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  event_date timestamp NULL DEFAULT NULL,
  waiver_link_path varchar(255),
  eventbrite varchar(255),
  blaster_eventbrite varchar(255),
  display boolean DEFAULT false,
  active boolean DEFAULT false,
  details TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY id ( id )
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

INSERT INTO lockins (id, title, event_date, waiver_link_path, eventbrite, blaster_eventbrite, display, active, details) VALUES
(1, "Entombed", "2018-03-23", "/lockin/waiver/lockin_waiver_fall18.pdf", "", "", 1, 0,
"BOLD[Important note to all player under the age of 18:]
Due to rules placed on us that are out of our control we require a parent/guardian to be present to sign your wavier in order to prove that a signature was not forged.
If your parent cannot be present to sign your wavier you will not be allowed to participate in the lock-in.
[LINE]
In the 6th dynasty of the golden age of Ancient Egypt, there lived the son of Montu, a Pharaoh of divine blood with Sekhmet’s fury raging in his soul. A Pharaoh whose soul was tainted, who became a harbinger of destruction; his name so cursed that few dare to speak it. His reign was paved with blood and fire, and so too was his death.

As soon as he became of age to be pharaoh, he killed his father. He brutally stabbed him into the sand, blade driven directly into the old man’s heart. He allowed his father no burial, no guide, and no means of obtaining eternal life with the gods.

He was Pharaoh, his will was the will of the gods.

After his rise, he waged a war on the Nile.

Soon it became evident that this man of war cared not for the gods: he craved bloodshed, craved conquering, and would go to Duat and back for his bloodlust.

Guided by the light of Ra, a peasant boy brought together a revolution, claiming he had seen the god in a dream, had been ordered by the fallen king of the gods, Osiris, to end the reign of a madman.

Soldiers and simple folk alike joined, overthrowing the slave prisons, freeing those who were taken from families, killing those loyal to the pharaoh.

Then the pharaoh’s guards, who, it was said, carried a piece of the pharaoh’s soul, came with pails of liquid fire. They set the cities ablaze, burning men, women and children alike.

From her window, the queen watched the Nile burn. She watched the people run screaming into the water, watched children lose family and friends. She watched the Nile burn and turn red with the blood of those seeking refuge from the flames. A single solitary tear slipped down her cheek, the mark of a mother mourning her young.

She sought the oracle of Pakhet, pleading for knowledge of what to do, how to stop this madness.

The oracle’s words were simple, “the madness of Pharaoh will never cease, nor will his bloodshed. If you wish for his end and the end of the wars he has wrought, you must drive a poisoned blade through his throat and trap his soul in the pieces of his sceptre. Should you fail to trap his soul, his fury will remain, his soul, once whole, will be too powerful to limit.”

Emboldened by these words, while seeking forgiveness for the sin she would commit, the queen and her handmaidens laced five daggers with the venom of the cobra. Each woman would kill one man that night, after Pharaoh had tired himself of his victory.

Each handmaiden entered the room of one of the guards, and the Queen entered the room of her husband.

She slit his throat where he slept, broke his sceptre and trapped pieces of his soul in the shards. She fled to her bed chambers, only to be awoken by screams when her work had been discovered.

Pharaoh’s reign had ended, and his burial was swift. His tomb was a maze, laden with the warriors who had served him most faithfully, with his royal guards around the entrance to Pharaoh’s final resting place.

With time, his cursed name faded, and his deeds were forgotten.

But mankind cannot leave demons to rest.

An Archaeologist by the name of Pierce Wolf stumbled upon the cursed tomb of the king, found the sceptre of the fallen Pharaoh. Unknowingly, he stole from that tomb the Pharaoh’s gold.

In anger at their disturbed place of rest, his soldiers and his guards rose to reclaim what was theirs, and to reawaken the Pharaoh’s fury once more."),
(2, "Close Encounters of the Undead Kind", "2018-11-16", "/lockin/waiver/lockin_waiver_spring18.pdf", "", "", 1, 0,
"BOLD[Important note to all player under the age of 18:]
Due to rules placed on us that are out of our control we require a parent/guardian to be present to sign your wavier in order to prove that a signature was not forged.
If your parent cannot be present to sign your wavier you will not be allowed to participate in the lock-in."),
(3, "Ragnarok", "2019-04-19", "/lockin/waiver/lockin_waiver_spring19.pdf", "", "", 1, 0,
"BOLD[Important note to all player under the age of 18:]
Due to rules placed on us that are out of our control we require a parent/guardian to be present to sign your wavier in order to prove that a signature was not forged.
If your parent cannot be present to sign your wavier you will not be allowed to participate in the lock-in."),
(4, "Ivy's Infection", "2019-11-22", "/lockin/waiver/lockin_waiver_fall19.pdf", "", "", 1, 0,
"BOLD[Important note to all player under the age of 18:]
Due to rules placed on us that are out of our control we require a parent/guardian to be present to sign your wavier in order to prove that a signature was not forged.
If your parent cannot be present to sign your wavier you will not be allowed to participate in the lock-in.");
