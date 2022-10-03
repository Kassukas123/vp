külg1 = int(input("Sisesta 1. külg "))
külg2 = int(input("Sisesta 2. külg "))
külg3 = int(input("Sisesta 3. külg "))

if külg1 + külg2 > külg3:
    print("Kolmnurka saab luua")
elif külg1 + külg3 < külg2:
    print("Kolmnurka saab luua")
elif külg3 + külg2 == külg1:
    print("Kolmnurka saab luua")
else
    print("Kolmnurka ei saa luua")