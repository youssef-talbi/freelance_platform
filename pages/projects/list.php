<?php
// Include header
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container">
    <div class="flex" style="gap: 30px; flex-wrap: wrap;">
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            <div class="card">
                <div class="card-content">
                    <h3>Project Categories</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="?category=web-development" class="p-2 mb-2 d-block">Web Development</a></li>
                        <li><a href="?category=mobile-apps" class="p-2 mb-2 d-block">Mobile Apps</a></li>
                        <li><a href="?category=design" class="p-2 mb-2 d-block">Design & Creative</a></li>
                        <li><a href="?category=writing" class="p-2 mb-2 d-block">Writing & Translation</a></li>
                        <li><a href="?category=marketing" class="p-2 mb-2 d-block">Marketing</a></li>
                        <li><a href="?category=video" class="p-2 mb-2 d-block">Video & Animation</a></li>
                        <li><a href="?category=admin" class="p-2 mb-2 d-block">Admin Support</a></li>
                        <li><a href="?category=it" class="p-2 mb-2 d-block">IT & Networking</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-content">
                    <h3>Filter Projects</h3>
                    <form action="" method="get">
                        <div class="form-group">
                            <label for="budget_min">Budget Range</label>
                            <div class="flex gap-10">
                                <input type="number" id="budget_min" name="budget_min" placeholder="Min" style="flex: 1;">
                                <input type="number" id="budget_max" name="budget_max" placeholder="Max" style="flex: 1;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="project_type">Project Type</label>
                            <select id="project_type" name="project_type">
                                <option value="">All Types</option>
                                <option value="fixed">Fixed Price</option>
                                <option value="hourly">Hourly Rate</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Skills</label>
                            <div class="form-check">
                                <input type="checkbox" id="skill_html" name="skills[]" value="html">
                                <label for="skill_html">HTML/CSS</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="skill_js" name="skills[]" value="javascript">
                                <label for="skill_js">JavaScript</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="skill_php" name="skills[]" value="php">
                                <label for="skill_php">PHP</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="skill_wordpress" name="skills[]" value="wordpress">
                                <label for="skill_wordpress">WordPress</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="skill_graphic" name="skills[]" value="graphic">
                                <label for="skill_graphic">Graphic Design</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-sm" style="width: 100%;">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div style="flex: 3; min-width: 300px;">
            <div class="flex justify-between items-center mb-4">
                <h2>Browse Projects</h2>
                <div>
                    <select id="sort" name="sort" onchange="this.form.submit()">
                        <option value="newest">Newest First</option>
                        <option value="budget_high">Budget: High to Low</option>
                        <option value="budget_low">Budget: Low to High</option>
                    </select>
                </div>
            </div>
            
            <!-- Project Listings -->
            <div class="project-list">
                <!-- Project 1 -->
                <div class="card mb-4">
                    <div class="card-content">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="mb-0">WordPress Website Development</h3>
                            <span class="badge badge-primary">Web Development</span>
                        </div>
                        <p>Looking for an experienced WordPress developer to create a business website with e-commerce functionality. The website should be responsive, fast-loading, and SEO-friendly. Experience with WooCommerce is required.</p>
                        <div class="flex justify-between items-center mt-3">
                            <div>
                                <p><strong>Budget:</strong> $500 - $1,000</p>
                                <p><strong>Posted:</strong> 2 days ago</p>
                            </div>
                            <div>
                                <p><strong>Proposals:</strong> 5</p>
                                <p><strong>Type:</strong> Fixed Price</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex gap-10">
                            <span class="badge badge-secondary">WordPress</span>
                            <span class="badge badge-secondary">WooCommerce</span>
                            <span class="badge badge-secondary">PHP</span>
                        </div>
                        <a href="/pages/projects/view.php?id=1" class="btn btn-sm">View Details</a>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="card mb-4">
                    <div class="card-content">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="mb-0">Logo Design for Tech Startup</h3>
                            <span class="badge badge-primary">Design</span>
                        </div>
                        <p>Need a modern, clean logo for our new tech startup. We are in the AI space and want something that conveys innovation and cutting-edge technology. The logo should work well in both color and black & white.</p>
                        <div class="flex justify-between items-center mt-3">
                            <div>
                                <p><strong>Budget:</strong> $200 - $300</p>
                                <p><strong>Posted:</strong> 1 day ago</p>
                            </div>
                            <div>
                                <p><strong>Proposals:</strong> 8</p>
                                <p><strong>Type:</strong> Fixed Price</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex gap-10">
                            <span class="badge badge-secondary">Logo Design</span>
                            <span class="badge badge-secondary">Branding</span>
                            <span class="badge badge-secondary">Illustrator</span>
                        </div>
                        <a href="/pages/projects/view.php?id=2" class="btn btn-sm">View Details</a>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="card mb-4">
                    <div class="card-content">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="mb-0">Content Writing for Blog</h3>
                            <span class="badge badge-primary">Writing</span>
                        </div>
                        <p>Seeking a content writer to create 10 blog posts about digital marketing trends. Each post should be 1,500+ words, well-researched, and optimized for SEO. Topics will include social media marketing, email campaigns, and content strategy.</p>
                        <div class="flex justify-between items-center mt-3">
                            <div>
                                <p><strong>Budget:</strong> $300 - $500</p>
                                <p><strong>Posted:</strong> 3 days ago</p>
                            </div>
                            <div>
                                <p><strong>Proposals:</strong> 12</p>
                                <p><strong>Type:</strong> Fixed Price</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex gap-10">
                            <span class="badge badge-secondary">Content Writing</span>
                            <span class="badge badge-secondary">SEO</span>
                            <span class="badge badge-secondary">Digital Marketing</span>
                        </div>
                        <a href="/pages/projects/view.php?id=3" class="btn btn-sm">View Details</a>
                    </div>
                </div>
                
                <!-- Project 4 -->
                <div class="card mb-4">
                    <div class="card-content">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="mb-0">Mobile App Development - iOS & Android</h3>
                            <span class="badge badge-primary">Mobile Apps</span>
                        </div>
                        <p>Looking for a mobile app developer to create a fitness tracking app for both iOS and Android. The app should include features like workout tracking, progress charts, and social sharing. Experience with React Native preferred.</p>
                        <div class="flex justify-between items-center mt-3">
                            <div>
                                <p><strong>Budget:</strong> $2,000 - $3,000</p>
                                <p><strong>Posted:</strong> 5 days ago</p>
                            </div>
                            <div>
                                <p><strong>Proposals:</strong> 7</p>
                                <p><strong>Type:</strong> Fixed Price</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex gap-10">
                            <span class="badge badge-secondary">React Native</span>
                            <span class="badge badge-secondary">iOS</span>
                            <span class="badge badge-secondary">Android</span>
                        </div>
                        <a href="/pages/projects/view.php?id=4" class="btn btn-sm">View Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center mt-5">
                <div class="pagination">
                    <a href="#" class="btn btn-sm">&laquo; Previous</a>
                    <a href="#" class="btn btn-sm active">1</a>
                    <a href="#" class="btn btn-sm">2</a>
                    <a href="#" class="btn btn-sm">3</a>
                    <a href="#" class="btn btn-sm">Next &raquo;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
require_once __DIR__ . '/../../includes/footer.php';
?>
