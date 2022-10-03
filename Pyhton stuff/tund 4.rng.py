import random
maks_arv = 100
maks_korduseid = 7
arvuti_arv = random.randint(1,maks_arv)
m2ngija_arv = int(input("Paku arv "))
korduseid = 1
while arvuti_arv != m2ngija_arv and korduseid < maks_korduseid:
    if arvuti_arv > m2ngija_arv:
        print("Pakuti liiga palju")
    else:
        print("Pakuti liiga vähe")
    m2ngija_arv = int(input("Paku uus arv "))
    korduseid = korduseid + 1
print("Õige")