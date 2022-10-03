import math
a = int(input("Sisesta a kordaja: "))
if a == 0:
    print("Nulliga ei saa a kordaja olla!!!")
    exit()
b = int(input("Sisesta b kordaja: "))
c = int(input("Sisesta c kordaja: "))

diskriminant = (b**2) - (4*a*c)
if diskriminant == 0:
    print("Nende andmetega ei anna võrrandit lahendada")
    quit()
else:
    lahendus1 = (-b + math.sqrt(diskriminant))/(2*a)
    lahendus2 = (-b - math.sqrt(diskriminant))/(2*a)

print(lahendus1)
print(lahendus2)

