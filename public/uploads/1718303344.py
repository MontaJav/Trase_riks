from openpyxl import load_workbook
import matplotlib.pyplot as plt
import numpy as np

Tabula = load_workbook("Stock.xlsx", data_only=True)
Loksne = Tabula["Sheet1"]
Starts = 1
Prices = []

while True:
    Adrese = "A" + str(Starts)
    if Loksne[Adrese].value is None: break
    PricesCommaToDot = Loksne[Adrese].value.replace(',', '.')
    Prices.append(float(PricesCommaToDot))
    Starts+=1
print("Data about", len(Prices), "stock prices.")

npDati = np.array(Prices)

#=== Grafiks ============================
bilde, ass = plt.subplots()
ass.boxplot(npDati, vert=False, showmeans=True, meanline=True, 
patch_artist=True,
medianprops={"linewidth":2, "color":"green"},
meanprops={"linewidth":2, "color":"red"} )
plt.show()