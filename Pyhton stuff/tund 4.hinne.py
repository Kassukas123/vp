max_punktid = int(input("Siseta töö max punktid: "))
vastus = "jah"
b_loendur = 0

while vastus == "jah":
    op_punktid = int(input("Sisesta õpilase punktid: "))
    tulemus = op_punktid / max_punktid * 100
   
    if tulemus >= 91 and tulemus <= 100:
        print ("Õpilane sai hindeks A ")
    if 81 <= tulemus <= 90:
        print ("Õpilane sai hindeks B ")
        b_loendur += 1
    if 71 <= tulemus <= 80:
        print ("Õpilane sai hindeks C ")
    if 61 <= tulemus <= 70:
        print ("Õpilane sai hindeks D ")
    if 50 <= tulemus <= 60:
        print ("Õpilane sai hindeks E ")
    if tulemus < 50:
        print("Õpilane kukkus läbi ehk F ")
    if tulemus > 100:
        print("Sisesta õige tulemus ")
    
    vastus = input("Kas töid on veel? (jah/ei)" )

print("Töö hindega B", b_loendur)