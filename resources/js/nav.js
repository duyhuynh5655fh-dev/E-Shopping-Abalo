"use strict";

export class NavigationMenu {
    constructor(menuData) {
        this._menuData = menuData;
    }

    addSubMenu(title, submenu) {
        const menuItem = this._menuData.find(item => item.title === title);
        if (menuItem) {
            menuItem.submenu = submenu;
        }
    }

    init() {
        const ul = document.createElement("ul");
        ul.className = "nav-main";

        this._menuData.forEach(item => {
            const li = document.createElement("li");
            li.className = "nav-item";
            const label = document.createElement("span");
            label.textContent = item.title;
            label.className = "nav-label";

            if (item.submenu) {
                const arrow = document.createElement("span");
                arrow.className = "arrow";
                arrow.textContent = "►";
                label.appendChild(arrow);

                const subUl = document.createElement("ul");
                subUl.className = "sub-menu hidden";

                item.submenu.forEach(subitem => {
                    const subLi = document.createElement("li");
                    subLi.textContent = subitem.title;
                    subLi.className = "sub-item";
                    subUl.appendChild(subLi);
                });

                label.addEventListener("click", (e) => {
                    e.stopPropagation();
                    const isOpen = !subUl.classList.contains("hidden");
                    this._closeAllSubmenus(ul);
                    if (!isOpen) {
                        subUl.classList.remove("hidden");
                        arrow.textContent = "▼";
                    } else {
                        subUl.classList.add("hidden");
                        arrow.textContent = "►";
                    }
                });

                li.appendChild(label);
                li.appendChild(subUl);
            } else {
                li.appendChild(label);
            }

            ul.appendChild(li);
        });

        const nav = document.createElement("nav");
        nav.className = "main-nav";
        nav.appendChild(ul);
        document.body.prepend(nav);
    }

    _closeAllSubmenus(navRoot) {
        const allSubmenus = navRoot.querySelectorAll(".sub-menu");
        const allArrows = navRoot.querySelectorAll(".arrow");
        allSubmenus.forEach(ul => ul.classList.add("hidden"));
        allArrows.forEach(arrow => arrow.textContent = "►");
    }
}

const menuData = [
    { title: "Home" },
    { title: "Kategorien" }, // Submenü
    { title: "Verkaufen" },
    {
        title: "Unternehmen",
        submenu: [
            { title: "Philosophie" },
            { title: "Karriere" }
        ]
    }
];

// Holt Kategorien aus DB
async function createSubmenuFromDB(uri, itemName) {
    try {
        const response = await fetch(uri);
        const data = await response.json();
        return data.map(e => ({ title: e[itemName] }));
    } catch (e) {
        console.error("Fehler beim Laden der Kategorien:", e);
        return [];
    }
}

// Alle Elemente initialisieren, nachdem das DOM geladen ist
document.addEventListener("DOMContentLoaded", async () => {
    const menu = new NavigationMenu(menuData);
    const kategorienSubmenu = await createSubmenuFromDB('/api/kategorien', 'ab_name');
    menu.addSubMenu("Kategorien", kategorienSubmenu);
    menu.init();
});
