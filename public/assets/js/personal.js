function mostrarTab(tab) {
  const tabs = ['perfil', 'cursos', 'misiones'];

  tabs.forEach(t => {
    // Contenido
    document.getElementById(t).classList.add('hidden');

    // Botón
    const btn = document.getElementById('tab-' + t);
    btn.classList.remove(
      'bg-[#0f0f0f]', 'text-yellow-500', 'z-10', 'py-3'
    );
    btn.classList.add(
      'bg-[#111]', 'text-gray-400', 'py-2'
    );
  });

  // Activo
  document.getElementById(tab).classList.remove('hidden');
  const activeBtn = document.getElementById('tab-' + tab);
  activeBtn.classList.add(
    'bg-[#0f0f0f]', 'text-yellow-500', 'z-10', 'py-3'
  );
}