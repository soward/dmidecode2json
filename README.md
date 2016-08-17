Provides a simple parsing of the output of dmidecode to JSON. 

Just include the .inc.php file and call dmiJson(), it will return a JSON array. 
Note that dmidecode typically needs root access to run, so the exec is wrapped with sudo -n.

dmidecode output like this:
```
# dmidecode 3.0
Getting SMBIOS data from sysfs.
SMBIOS 2.8 present.
51 structures occupying 1996 bytes.
Table at 0x3A079000.

Handle 0x0000, DMI type 0, 24 bytes
BIOS Information
        Vendor: Intel Corp.
        Version: FCBYT10H.86A.0031.2015.1027.1417
        Release Date: 10/27/2015
        Address: 0xF0000
        Runtime Size: 64 kB
        ROM Size: 6592 kB
        Characteristics:
                PCI is supported
                BIOS is upgradeable
                BIOS shadowing is allowed
                Boot from CD is supported
                Selectable boot is supported
                EDD is supported
                5.25"/1.2 MB floppy services are supported (int 13h)
                3.5"/720 kB floppy services are supported (int 13h)
                3.5"/2.88 MB floppy services are supported (int 13h)
                Print screen service is supported (int 5h)
                Serial services are supported (int 14h)
                Printer services are supported (int 17h)
                ACPI is supported
                USB legacy is supported
                BIOS boot specification is supported
                Targeted content distribution is supported
                UEFI is supported
        BIOS Revision: 5.6
```

will turn into JSON that looks like this:

```
Array
(
    [BIOS Information] => Array
        (
            [Vendor] => Array
                (
                    [0] => Intel Corp
                )

            [Version] => Array
                (
                    [0] => FCBYT10H
                )

            [Release Date] => Array
                (
                    [0] => 10/27/2015
                )

            [Address] => Array
                (
                    [0] => 0xF0000
                )

            [Runtime Size] => Array
                (
                    [0] => 64 kB
                )

            [ROM Size] => Array
                (
                    [0] => 6592 kB
                    [1] => Characteristics:
                    [2] => PCI is supported
                    [3] => BIOS is upgradeable
                    [4] => BIOS shadowing is allowed
                    [5] => Boot from CD is supported
                    [6] => Selectable boot is supported
                    [7] => EDD is supported
                    [8] => 5.25"/1.2 MB floppy services are supported (int 13h)
                    [9] => 3.5"/720 kB floppy services are supported (int 13h)
                    [10] => 3.5"/2.88 MB floppy services are supported (int 13h)
                    [11] => Print screen service is supported (int 5h)
                    [12] => Serial services are supported (int 14h)
                    [13] => Printer services are supported (int 17h)
                    [14] => ACPI is supported
                    [15] => USB legacy is supported
                    [16] => BIOS boot specification is supported
                    [17] => Targeted content distribution is supported
                    [18] => UEFI is supported
                )

            [BIOS Revision] => Array
                (
                    [0] => 5
                )

        )
)
```
